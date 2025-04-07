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
            $checkout = $this->checkoutService->processCheckout($validated);

            if ($checkout['error']) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'payment' => $checkout['message']
                    ]);
            }

            if ($validated['payment_method'] == 1) {
                return view('pix', [
                    'encodedImage' => $checkout['encodedImage'],
                    'expirationDate' => $checkout['expirationDate'],
                    'routeHome' => route('checkout.index', ['produto' => $validated['product_id']]),
                ]);
            }

            if ($validated['payment_method'] == 3) {
                return view('billet', [
                    'billetUrl' => $checkout['payment']['bankSlipUrl'],
                    'routeHome' => route('checkout.index', ['produto' => $validated['product_id']]),
                ]);
            }


            return view('success', [
                'routeHome' => route('checkout.index', ['produto' => $validated['product_id']]),
            ]);

        } catch (\Exception $exception) {

            dd($exception);
            return redirect()->back()->with('error', 'Erro ao processar o pagamento: ' . $exception->getMessage());
        }
    }

}
