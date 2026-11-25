<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            // Book 1 (3件)
            ['user_id' => 1, 'book_id' => 1, 'rating' => 5, 'comment' => '物語の展開が面白く、一気に読み切りました。'],
            ['user_id' => 2, 'book_id' => 1, 'rating' => 4, 'comment' => '登場人物の描写が丁寧で感情移入できました。'],
            ['user_id' => 3, 'book_id' => 1, 'rating' => 4, 'comment' => '読みやすく初心者にもおすすめです。'],

            // Book 2 (3件)
            ['user_id' => 2, 'book_id' => 2, 'rating' => 5, 'comment' => '仕事にすぐ活かせる内容が多く参考になりました。'],
            ['user_id' => 3, 'book_id' => 2, 'rating' => 4, 'comment' => '具体例が豊富で理解しやすかったです。'],
            ['user_id' => 4, 'book_id' => 2, 'rating' => 3, 'comment' => '内容は良いですが少し難しく感じました。'],

            // Book 3 (3件)
            ['user_id' => 1, 'book_id' => 3, 'rating' => 5, 'comment' => '技術解説が分かりやすく学習に役立ちました。'],
            ['user_id' => 4, 'book_id' => 3, 'rating' => 4, 'comment' => 'サンプルコードが豊富で実践的です。'],
            ['user_id' => 5, 'book_id' => 3, 'rating' => 4, 'comment' => '初心者から中級者まで幅広くおすすめできます。'],

            // Book 4 (3件)
            ['user_id' => 2, 'book_id' => 4, 'rating' => 3, 'comment' => '考え方は参考になりました。'],
            ['user_id' => 4, 'book_id' => 4, 'rating' => 4, 'comment' => '前向きな気持ちになれる一冊でした。'],
            ['user_id' => 5, 'book_id' => 4, 'rating' => 5, 'comment' => '人生観が変わるほどの学びがありました。'],

            // Book 5 (3件)
            ['user_id' => 1, 'book_id' => 5, 'rating' => 4, 'comment' => '文章が読みやすく楽しめました。'],
            ['user_id' => 3, 'book_id' => 5, 'rating' => 3, 'comment' => '期待通りの内容でした。'],
            ['user_id' => 5, 'book_id' => 5, 'rating' => 5, 'comment' => '著者の経験談が非常に参考になりました。'],

            // Book 6 (3件)
            ['user_id' => 1, 'book_id' => 6, 'rating' => 4, 'comment' => '歴史の流れが整理されていて分かりやすいです。'],
            ['user_id' => 2, 'book_id' => 6, 'rating' => 5, 'comment' => '深い知識を得られる良書でした。'],
            ['user_id' => 4, 'book_id' => 6, 'rating' => 3, 'comment' => '内容は良いですが少し専門的でした。'],

            // Book 7 (3件)
            ['user_id' => 2, 'book_id' => 7, 'rating' => 4, 'comment' => '科学への興味がより深まりました。'],
            ['user_id' => 3, 'book_id' => 7, 'rating' => 5, 'comment' => '難しい内容を分かりやすく解説しています。'],
            ['user_id' => 5, 'book_id' => 7, 'rating' => 4, 'comment' => '知的好奇心を刺激されました。'],

            // Book 8 (3件)
            ['user_id' => 1, 'book_id' => 8, 'rating' => 3, 'comment' => '芸術の基礎を学ぶのに適していると思います。'],
            ['user_id' => 4, 'book_id' => 8, 'rating' => 5, 'comment' => '作品の見方が変わりました。'],
            ['user_id' => 5, 'book_id' => 8, 'rating' => 4, 'comment' => '美しい図版が多く楽しめました。'],

            // Book 9 (3件)
            ['user_id' => 2, 'book_id' => 9, 'rating' => 5, 'comment' => 'すぐ作りたくなるレシピが満載です。'],
            ['user_id' => 3, 'book_id' => 9, 'rating' => 4, 'comment' => '家庭で再現しやすい内容でした。'],
            ['user_id' => 4, 'book_id' => 9, 'rating' => 3, 'comment' => '初心者向けで分かりやすかったです。'],

            // Book 10 (2件)
            ['user_id' => 1, 'book_id' => 10, 'rating' => 4, 'comment' => '旅行気分を味わえる楽しい一冊でした。'],
            ['user_id' => 5, 'book_id' => 10, 'rating' => 5, 'comment' => '写真が豊富で見ているだけでも楽しめます。'],

            // Book 11 (3件)
            ['user_id' => 2, 'book_id' => 11, 'rating' => 4, 'comment' => '最後まで飽きずに読むことができました。'],
            ['user_id' => 3, 'book_id' => 11, 'rating' => 5, 'comment' => '内容が充実しており満足度が高いです。'],
            ['user_id' => 4, 'book_id' => 11, 'rating' => 4, 'comment' => '友人にもおすすめしたいと思いました。'],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}