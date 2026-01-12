<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ensure existing bad data doesn't break constraint creation (safety)
        DB::statement("
            UPDATE branches
            SET status = 'active'
            WHERE status IS NULL OR status NOT IN ('active', 'archived')
        ");

        // Add CHECK constraint
        DB::statement("
            ALTER TABLE branches
            ADD CONSTRAINT branches_status_check
            CHECK (status IN ('active', 'archived'))
        ");
    }

    public function down(): void
    {
        // Drop CHECK constraint
        DB::statement("
            ALTER TABLE branches
            DROP CHECK branches_status_check
        ");
    }
};
