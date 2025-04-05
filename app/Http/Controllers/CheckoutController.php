<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;
use App\Services\ProductService;

class CheckoutController extends Controller
{
    protected ProductService $productService;
    protected CheckoutService $checkoutService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(int $id)
    {
        $product = $this->productService->findById($id);
        if (!$product) {
            return view('welcome', ['message' => 'Produto não encontrado']);
        }
        return view('checkout', ['product' => $product]);
    }


    public function processPayment(CheckoutRequest $request)
    {
        $validated = $request->validated();
        $validated['product'] = $this->productService->findById($validated['product_id'])->toArray();
        $this->checkoutService = app(CheckoutService::class);
        try {
            dd($this->checkoutService->processCheckout($validated));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->back()->with('error', 'Erro ao processar o pagamento: ' . $exception->getMessage());
        }
    }

}
