<?php

namespace App\Http\Service;

use App\Models\Element;
use Illuminate\Support\Arr;

class ElementService extends BaseService
{
    public function getAllElements()
    {
        $elements = Element::all();
        return $elements;
    }

    public function getElementById($id)
    {
        $element = Element::find($id);
        if (!$element) {
            return $this->error('Element not found', 404, [
                'element' => $element
            ]);
        }
        return $this->success([
            'element' => $element
        ], 'Element retrieved successfully', 200);
    }

    public function addElement(array $data)
    {
        $element = Element::create($data);
        return $this->success([
            'element' => $element
        ], 'Element created successfully', 201);
    }

    public function updateElement(array $data, $id)
    {
        $element = Element::find($id);
        if (!$element) {
            return $this->error('Element not found', 404, [
                'element' => $element
            ]);
        }
        $element->update($data);
        return $this->success([
            'element' => $element
        ], 'Element updated successfully', 200);
    }

    public function deleteElement($id)
    {
        $element = Element::find($id);
        if (!$element) {
            return $this->error('Element not found', 404, [
                'element' => $element
            ]);
        }
        $element->delete();
        return $this->success([
            'element' => $element
        ], 'Element deleted successfully', 200);
    }
}
