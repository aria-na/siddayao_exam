<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        // ------------------------------------------
        // OPTION 1: POSTGRESQL (For the Cloud)
        // ------------------------------------------
        if ($driver === 'pgsql') {
            // Postgres requires a Function first
            DB::unprepared('
                CREATE OR REPLACE FUNCTION log_tweet_insert()
                RETURNS TRIGGER AS $$
                BEGIN
                    INSERT INTO logs (action, table_name, record_id, new_values, created_at)
                    VALUES (
                        \'INSERT\', 
                        \'tweets\', 
                        NEW.id, 
                        json_build_object(\'content\', NEW.content, \'user_id\', NEW.user_id), 
                        NOW()
                    );
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;
            ');

            // Then bind the Trigger to the Function
            DB::unprepared('
                CREATE TRIGGER tr_tweets_insert
                AFTER INSERT ON tweets
                FOR EACH ROW
                EXECUTE FUNCTION log_tweet_insert();
            ');
        } 
        
        // ------------------------------------------
        // OPTION 2: MYSQL (For your Local XAMPP)
        // ------------------------------------------
        elseif ($driver === 'mysql') {
            DB::unprepared('
                CREATE TRIGGER tr_tweets_insert AFTER INSERT ON tweets FOR EACH ROW
                BEGIN
                    INSERT INTO logs (action, table_name, record_id, new_values, created_at)
                    VALUES ("INSERT", "tweets", NEW.id, JSON_OBJECT("content", NEW.content, "user_id", NEW.user_id), NOW());
                END
            ');
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::unprepared('DROP TRIGGER IF EXISTS tr_tweets_insert ON tweets');
            DB::unprepared('DROP FUNCTION IF EXISTS log_tweet_insert');
        } else {
            DB::unprepared('DROP TRIGGER IF EXISTS tr_tweets_insert');
        }
    }
};