<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $table = 'applications';
        $func_name = 'application_histories_func';
        $trigger_name = 'application_histories_trigger';
        DB::statement("
            create function $func_name() returns trigger
                    language plpgsql
                as
                $$
                    BEGIN
                    if old.status <> new.status then
                        insert into application_histories(application_id, old_status, new_status, created_at, updated_at) values
                        (old.id, old.status, new.status, now() at time zone 'utc -5', now() at time zone 'utc -5');
                    end if;
                        return new;
                end;
                $$;
        ");
        DB::statement("create trigger $trigger_name
                after update
                on $table
                for each row
            execute procedure $func_name();");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $func_name = 'application_histories_func';
        $trigger_name = 'application_histories_trigger';
        DB::statement("DROP TRIGGER  IF EXISTS $trigger_name;");
        DB::statement("DROP FUNCTION  IF EXISTS $func_name;");
    }
};
