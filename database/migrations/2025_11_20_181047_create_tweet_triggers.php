<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER tr_tweets_insert AFTER INSERT ON tweets FOR EACH ROW
            BEGIN
                INSERT INTO logs (action, table_name, record_id, new_values, created_at)
                VALUES ("INSERT", "tweets", NEW.id, JSON_OBJECT("content", NEW.content, "user_id", NEW.user_id), NOW());
            END
        ');

        DB::unprepared('
            CREATE TRIGGER tr_tweets_update AFTER UPDATE ON tweets FOR EACH ROW
            BEGIN
                INSERT INTO logs (action, table_name, record_id, old_values, new_values, created_at)
                VALUES ("UPDATE", "tweets", NEW.id, 
                        JSON_OBJECT("content", OLD.content), 
                        JSON_OBJECT("content", NEW.content), 
                        NOW());
            END
        ');

        DB::unprepared('
            CREATE TRIGGER tr_tweets_delete AFTER DELETE ON tweets FOR EACH ROW
            BEGIN
                INSERT INTO logs (action, table_name, record_id, old_values, created_at)
                VALUES ("DELETE", "tweets", OLD.id, JSON_OBJECT("content", OLD.content), NOW());
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_tweets_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS tr_tweets_update');
        DB::unprepared('DROP TRIGGER IF EXISTS tr_tweets_delete');
    }
};
