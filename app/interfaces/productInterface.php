<?php

namespace App\Interfaces;

interface productInterface {
    public function all();
    public function show($id);
    public function store($data);
    public function update($data, $id);
    public function destroy($id);
}
