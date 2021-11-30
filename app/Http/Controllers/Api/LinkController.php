<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Models\ShortLink;
use App\Service\NamedShortGenerate;
use App\Service\ShortGenerate;
use App\Service\ShortLinkGenerator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends Controller
{
    public function addLink(Request $request, ShortLinkGenerator $generator)
    {
        $request->validate(
            [
                'long_url' => 'url',
                'date' => 'nullable|date_format:Y-m-d'
            ]
        );
        $type = $request->input('type', 'simpleShort');
        $link = $generator->generate(
            ShortGenerate::create(
                0,
                $request->input('long_url'),
                $request->input('date'),
                'shortWithKey' === $type
            )
        );
        return new LinkResource($link);
    }

    public function addNamedLink(Request $request, ShortLinkGenerator $generator)
    {
        $request->validate(
            [
                'long_url' => 'url',
                'date' => 'nullable|date_format:Y-m-d'
            ]
        );
        $link = $generator->generateNamed(
            NamedShortGenerate::create(
                0,
                $request->input('long_url'),
                $request->input('date'),
                $request->input('name')
            )
        );
        return new LinkResource($link);
    }

    public function deleteLink($id)
    {
        $link = ShortLink::where('id', $id)->first();
        if (!$link) {
            throw new NotFoundHttpException('Link not found');
        }
        $link->delete();
        return response()->json(null, 204);
    }


}
