<?php

namespace App\Repositories\PaymentGateway;

interface PaymentGatewayInterface {
    public function all();
    public function find($id);
    public function filter($request);
    public function store($request);
    public function update($id, $request);
    public function destroy($id);
}
