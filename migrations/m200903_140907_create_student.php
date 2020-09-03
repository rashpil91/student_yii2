<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200903_140907_create_student
 */
class m200903_140907_create_student extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('student', [
            'id' => Schema::TYPE_PK,
            'lastname' => $this->string(50)->notNull(),
            'firstname' => $this->string(50)->notNull(),
            'patronymic' => $this->string(50)->notNull(),
            'student_groupe' => $this->integer(11)->notNull(),
            'photo' => Schema::TYPE_STRING . ' NOT NULL',
            'falled' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->batchInsert('student',
            ['firstname', 'lastname', 'patronymic', 'student_groupe', 'photo', 'falled', 'created_at', 'user_id'], 
            [
                ['Григорий', 'Аминев', 'Адрианович', 3, '1598982937_dwNqa.png', 0, 1598980589, 100],
                ['Вячеслав', 'Степанов', 'Макарович', 1, '1599038422_cpY8P.png', 0, 1599038403, 100],
                ['Ариадна', 'Гибазова', 'Александровна', 1, '1599038535_gNCSQ.png', 0, 1599038522, 100],
                ['Ульян', 'Пересторонин', 'Сигизмундович', 1, '1599038591_s6ALs.png', 0, 1599038587, 100],
                ['Розалия', 'Бершова', 'Ильевна', 2, '1599038690_W-l_-.png', 0, 1599038685, 100],
                ['Жанна', 'Дорохова', 'Павловна', 2, '1599038764_yOgR8.png', 0, 1599038750, 100],
                ['Матвей', 'Пушменков', 'Пахомович', 2, '1599038807_K7K4M.png', 0, 1599038795, 100],
                ['Александр', 'Янкин', 'Наумович', 2, '1599038847_E5SbO.png', 0, 1599038833, 100],
                ['Валерий', 'Жабкин', 'Денисович', 2, '1599038892_Shzgl.png', 0, 1599038881, 100],
                ['Эмилия', 'Крутина', 'Николаевна', 2, '1599038968_kXl0X.png', 0, 1599038901, 100],
                ['Эмма', 'Серпионова', 'Дмитриевна', 2, '1599039057_Cos-S.png', 0, 1599039042, 100],
                ['Клара', 'Ахтемирова', 'Сергеевна', 1, '1599039163__UYB5.png', 0, 1599039153, 100],
                ['Инна', 'Муленко', 'Афанасиевна', 1, '1599039214_ANFzh.png', 0, 1599039201, 100],
                ['Кирилл', 'Бугаев', 'Сидорович', 3, '1599039285_q58Dk.png', 0, 1599039271, 100],
                ['Клара', 'Степанкова', 'Никоновна', 3, '1599039362_2jO46.png', 0, 1599039349, 100],
                ['Виталий', 'Чигиркин', 'Еремеевич', 3, '1599039423_OEWk-.png', 0, 1599039411, 100],
                ['Саввелий', 'Погодин', 'Дмитриевич', 1, '1599039497_td01B.png', 0, 1599039485, 100]
          ]
        );

        $this->createTable('course', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'time' => $this->integer(11)->notNull()
        ]);

        $this->batchInsert('course', ['id', 'name', 'time'], 
        [
            [1, 'Кулинарные курсы', 50],
            [3, 'Java для чайников', 600]       
        ]);

        $this->createTable('log', [
            'id' => Schema::TYPE_PK,
            'event' => $this->integer(3)->notNull(),
            'date' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'extra' => Schema::TYPE_TEXT,
            'ip' => Schema::TYPE_STRING . ' NOT NULL'
        ]);

        $this->batchInsert('log', ['event', 'date', 'user_id', 'extra', 'ip'], 
        [
            [2, 1599074963, 100, 'Крупнов Глеб Вячеславович', '127.0.0.1'],
            [2, 1599075113, 100, 'Ювелев Ким  Всеволодович', '127.0.0.1'],
            [1, 1599114793, 100, 'Бершова Клара Аристарховна', '127.0.0.1'],
            [1, 1599134775, 100, 'Бершова Клара Макарович', '127.0.0.1'],
            [2, 1599134958, 100, 'Бершова Клара Макарович', '127.0.0.1'],
            [2, 1599134977, 100, 'Пересторонин Полина Аристарховна', '127.0.0.1'],
            [2, 1599135122, 100, 'Шамило Вячеслав Сигизмундович', '127.0.0.1'],
            [1, 1599135497, 100, 'Пересторонин Клара Александровна', '127.0.0.1'],
            [1, 1599135779, 100, 'Степанов Клара Сигизмундович', '127.0.0.1'],
            [2, 1599135805, 100, 'Степанов Клара Сигизмундович', '127.0.0.1']      
        ]);

        $this->createTable('student_groupe', [
            'id' => Schema::TYPE_PK,
            'number' => $this->integer(5)->notNull()
        ]);  
        
        $this->batchInsert('student_groupe', ['id','number'], 
        [
            [1, 456],
            [2, 8080],
            [3, 232]      
        ]);
        
        $this->createTable('student_groupe_course_with_teacher', [
            'id' => Schema::TYPE_PK,
            'student_groupe' => $this->integer()->notNull(),
            'teacher' => $this->integer()->notNull(),
            'course' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()
        ]);  
        
        $this->batchInsert('student_groupe_course_with_teacher', ['id', 'student_groupe', 'teacher', 'course', 'status'], 
        [
            [5, 2, 8, 1, 1],
            [6, 1, 1, 1, 1],
            [7, 3, 8, 1, 1],
            [8, 1, 1, 3, 0],
            [9, 3, 8, 3, 0],
            [11, 1, 8, 3, 0]      
        ]);        

        $this->createTable('teacher', [
            'id' => Schema::TYPE_PK,
            'firstname' => $this->string(50)->notNull(),
            'lastname' => $this->string(50)->notNull(),
            'patronymic' => $this->string(50)->notNull(),
        ]);  
        
        $this->batchInsert('teacher', ['id', 'firstname', 'lastname', 'patronymic'], 
        [
            [1, 'Станислав', 'Лызлов', 'Адамович'],
            [8, 'Казимир', 'Яминский', 'Евлампиевич']      
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('course');
        $this->dropTable('log');
        $this->dropTable('student');
        $this->dropTable('student_groupe');
        $this->dropTable('student_groupe_course_with_teacher');
        $this->dropTable('teacher');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_140907_create_student cannot be reverted.\n";

        return false;
    }
    */
}
