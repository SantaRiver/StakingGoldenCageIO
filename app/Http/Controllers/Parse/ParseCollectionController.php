<?php

namespace App\Http\Controllers\Parse;

use App\Http\Controllers\Controller;
use App\Models\Cards;
use App\Models\CardsImg;
use App\Models\CardsStaking;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ParseCollectionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $params = [
            'collection_name' => 'goldencageio',
            'page' => '1',
            'limit' => '500',
            'order' => 'desc',
            'sort' => 'created',
        ];
        $newCards = [];
        $apiUrl = 'https://wax.api.atomicassets.io/atomicassets/v1/templates?'.http_build_query($params);
        $response = Http::get($apiUrl);
        if ($response->json()['success']) {
            $responseData = $response->json()['data'];
            foreach ($responseData as $item) {
                if (empty(Cards::query()->where('template_id', $item['template_id'])->first()) && isset($item['name'])) {
                    if (isset($item['immutable_data']['img'])){
                        $imgCode = $item['immutable_data']['img'];
                    } else {
                        $imgCode = $item['immutable_data']['backimg'];
                    }
                    $imgUrl = 'https://gateway.pinata.cloud/ipfs/'.$imgCode;
                    $responseImg = Http::get($imgUrl);

                    $extension = explode('/', $responseImg->header('Content-Type'))[1];
                    $fileName = $imgCode.'.'.$extension;
                    $filePreviewName = $imgCode.'_preview.'.$extension;
                    Storage::disk('public')->put('cards/'.$fileName, $responseImg);
                    $path = Storage::disk('public')->path('cards/'.$fileName);

                    $img = Image::make($path);
                    $img->resize(round($img->getWidth() / 6), round($img->getHeight() / 6));
                    $img->save($img->dirname.'/'.$filePreviewName);

                    $nft = new Cards(
                        [
                            'template_id' => $item['template_id'],
                            'name' => $item['name'],
                            'rarity' => $item['immutable_data']['rarity'] ?? null,
                            'description' => $item['immutable_data']['description'] ?? null,
                            'schema' => $item['schema']['schema_name'] ?? null,
                            'active' => 0,
                        ]
                    );
                    $nft->save();
                    $newCards[] = $nft->toArray();
                    $nft_img = new CardsImg(
                        [
                            'card_id' => $nft->id,
                            'img' => $fileName,
                            'preview' => $filePreviewName,
                        ]
                    );
                    $nft_staking = new CardsStaking(
                        [
                            'card_id' => $nft->id,
                        ]
                    );
                    $nft_img->save();
                    $nft_staking->save();
                }
            }
        }
        return response()->json(
            [
                'status' => 'success',
                'cards' => $newCards
            ]
        );
    }
}
