<?php

namespace App\Jobs\Guardian;

use App\Enums\Language;
use App\Models\{Article, Category};
use Carbon\Carbon;
use Illuminate\Bus\{Batchable, Queueable};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class ImportArticle implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $categoryId;

    public function __construct(
        public array $data,
        public int $sourceId
    ) {
        $this->categoryId = Category::query()
            ->firstOrCreate([
                'name'  => $this->data['sectionId'],
                'title' => $this->data['sectionName'],
            ])->id;
    }

    public function handle(): void
    {
        Article::query()
            ->updateOrCreate([
                'title'        => $this->data['webTitle'],
                'url'          => $this->data['webUrl'],
                'language'     => Language::EN->value,
                'published_at' => Carbon::createFromFormat('Y-m-d', substr($this->data['webPublicationDate'], 0, 10)),
                'category_id'  => $this->categoryId,
                'source_id'    => $this->sourceId,
            ]);
    }
}
