<?php namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Modules\Core\Entities\Locale;
use Modules\Post\Entities\Taxonomy;
use Modules\Post\Entities\TaxonomyDetail;

class PostTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxonomies')->delete();
        DB::beginTransaction();

        try {
            $taxonomy = Taxonomy::create([
                'type'  => 'post_category',
                'order' => 99,
                'count' => 0
            ]);

            $locale = Locale::where('code', '=', app()->getLocale())->first();

            TaxonomyDetail::create([
                'name'        => 'Default',
                'slug'        => 'default',
                'description' => 'Default Post Taxonomy',
                'locale_id'   => $locale->id,
                'taxonomy_id' => $taxonomy->id
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
        }
    }

}