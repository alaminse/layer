<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('is_default')->default(false);
            $table->string('status')->nullable()->default('published');
            $table->unsignedBigInteger('organization_id')->nullable()->default(1);
            $table->timestamps();
        });

        $pages = [
            [
                "title" => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'body' => <<<'EOD'
                    <h1>Lorem Ipsum</h1>
                    <h4>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h4>
                    <h5>"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."</h5>
                    <hr>
                    <div>
                    <h2>What is Lorem Ipsum?</h2>
                    <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the industry's standard
                    dummy text ever since the 1500s, when an unknown printer took a galley
                    of type and scrambled it to make a type specimen book. It has survived
                    not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with
                    the release of Letraset sheets containing Lorem Ipsum passages, and more
                     recently with desktop publishing software like Aldus PageMaker
                    including versions of Lorem Ipsum.</p>
                    </div><div>
                    <h2>Why do we use it?</h2>
                    <p>It is a long established fact that a reader will be distracted by the
                     readable content of a page when looking at its layout. The point of
                    using Lorem Ipsum is that it has a more-or-less normal distribution of
                    letters, as opposed to using 'Content here, content here', making it
                    look like readable English. Many desktop publishing packages and web
                    page editors now use Lorem Ipsum as their default model text, and a
                    search for 'lorem ipsum' will uncover many web sites still in their
                    infancy. Various versions have evolved over the years, sometimes by
                    accident, sometimes on purpose (injected humour and the like).</p>
                    </div>
                EOD,
                'status' => 'published',
                'is_default' => 1,
            ],
            [
                "title" => 'Terms of Service',
                'slug' => 'terms-of-service',
                'body' => <<<'EOD'
                    <h1>Lorem Ipsum</h1>
                    <h4>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h4>
                    <h5>"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."</h5>
                    <hr>
                    <div>
                    <h2>What is Lorem Ipsum?</h2>
                    <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the industry's standard
                    dummy text ever since the 1500s, when an unknown printer took a galley
                    of type and scrambled it to make a type specimen book. It has survived
                    not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with
                    the release of Letraset sheets containing Lorem Ipsum passages, and more
                     recently with desktop publishing software like Aldus PageMaker
                    including versions of Lorem Ipsum.</p>
                    </div><div>
                    <h2>Why do we use it?</h2>
                    <p>It is a long established fact that a reader will be distracted by the
                     readable content of a page when looking at its layout. The point of
                    using Lorem Ipsum is that it has a more-or-less normal distribution of
                    letters, as opposed to using 'Content here, content here', making it
                    look like readable English. Many desktop publishing packages and web
                    page editors now use Lorem Ipsum as their default model text, and a
                    search for 'lorem ipsum' will uncover many web sites still in their
                    infancy. Various versions have evolved over the years, sometimes by
                    accident, sometimes on purpose (injected humour and the like).</p>
                    </div>
                EOD,
                'status' => 'published',
                'is_default' => 1,
            ],
            [
                "title" => 'Refund Policy',
                'slug' => 'refund-policy',
                'body' => <<<'EOD'
                    <h1>Lorem Ipsum</h1>
                    <h4>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h4>
                    <h5>"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."</h5>
                    <hr>
                    <div>
                    <h2>What is Lorem Ipsum?</h2>
                    <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the industry's standard
                    dummy text ever since the 1500s, when an unknown printer took a galley
                    of type and scrambled it to make a type specimen book. It has survived
                    not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with
                    the release of Letraset sheets containing Lorem Ipsum passages, and more
                     recently with desktop publishing software like Aldus PageMaker
                    including versions of Lorem Ipsum.</p>
                    </div><div>
                    <h2>Why do we use it?</h2>
                    <p>It is a long established fact that a reader will be distracted by the
                     readable content of a page when looking at its layout. The point of
                    using Lorem Ipsum is that it has a more-or-less normal distribution of
                    letters, as opposed to using 'Content here, content here', making it
                    look like readable English. Many desktop publishing packages and web
                    page editors now use Lorem Ipsum as their default model text, and a
                    search for 'lorem ipsum' will uncover many web sites still in their
                    infancy. Various versions have evolved over the years, sometimes by
                    accident, sometimes on purpose (injected humour and the like).</p>
                    </div>
                EOD,
                'status' => 'published',
                'is_default' => 1,
            ],
        ];

        \App\Models\Page::insert($pages);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
