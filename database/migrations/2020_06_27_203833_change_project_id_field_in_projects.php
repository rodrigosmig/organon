<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProjectIdFieldInProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            DB::statement("ALTER TABLE tasks DROP FOREIGN KEY tasks_project_id_foreign, MODIFY project_id BIGINT UNSIGNED NOT NULL");
            DB::statement("ALTER TABLE tasks MODIFY project_id BIGINT UNSIGNED DEFAULT NULL");
            DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_project_id_foreign FOREIGN KEY (project_id) REFERENCES projects (id)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            DB::statement("ALTER TABLE tasks DROP FOREIGN KEY tasks_project_id_foreign, MODIFY project_id BIGINT UNSIGNED NOT NULL");
            DB::statement("ALTER TABLE tasks MODIFY project_id BIGINT UNSIGNED NOT NULL");
            DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_project_id_foreign FOREIGN KEY (project_id) REFERENCES projects (id)");
        });
    }
}
