<?php

namespace App\Http\Controllers;

use App\Extensions\ListsTrait;
use App\Extensions\RequestsTrait;
use App\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    use ListsTrait;
    use RequestsTrait;

    /**
     * List the products from a board
     *
     * @param int $id board id
     * @return json
     */
    public function showProductsFromBoard($id)
    {
        $products = Requests::where(['boards_id' => $id, 'status_id' => 2])->first();

        if (!is_null($products)) {
            $products = $products->products()->get();

            // add the ingredients and category to $products Collection
            $this->addListsCollection($products, ['ingredients', 'category']);
        }

        return Response::json($products ?: [
            'message' => 'no products founded to this board.',
            'return' => null,
        ]);
    }

    /**
     * Create or just attach new products to a request
     *
     * @param $id
     * @param Request $request
     * @return json
     */
    public function saveRequest($id, Request $request)
    {
        return Response::json($this->request($id, $request->all()));
    }
}
