<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;
abstract class Controller
{
    protected function getYamlConfig($filename){
        return Yaml::parseFile(config_path("yaml/{$filename}.yaml"));
    }

    public function replacePlaceholders(array $values, array $data){
        array_walk_recursive($data, function (&$item) use ($values) {
            $item = preg_replace_callback('/\{(\d+)\}/', function ($matches) use ($values) {
                $index = (int)$matches[1];
                return isset($values[$index]) ? $values[$index] : $matches[0]; // Reemplaza solo si el índice existe
            }, $item);
        });

        return $data;
    }

    public function getActions($actions, $values) {
        $actions = $this->replacePlaceholders($values, $actions);

        $html = '<div class="d-flex align-items-center">';

        foreach ($actions as $action) {
            if (is_array($action)) $action = (object) $action;
            if (isset($action->options)) {
                $html .= $this->getDropdown($action->options);
            }else{
                $html .= $this->getActionLink($action);
            }
        }

        $html .= '</div>';
        return $html;
    }
    
    private function getActionLink($action) {
        $dataAttributes = $this->getDataAttributes($action->data);
        
        return '<a href="javascript:;" class="text-body ' . htmlspecialchars($action->class) . '" ' . $dataAttributes . '>
                    <i class="ri-' . htmlspecialchars($action->icon) . '-line ti-sm me-2"></i>
                </a>';
    }
    
    private function getDropdown($options) {
        $html = '<span class="dropdown">
                    <a href="javascript:;"  class="text-body cursor-pointer" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-2-line"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">';
        
        foreach ($options as $option) {
            if(is_array($option)) $option=(object) $option;
            $dataAttributes = $this->getDataAttributes($option->data);
            $html .= '<a class="dropdown-item" href="#" ' . $dataAttributes . '>' . htmlspecialchars($option->label) . '</a>';
        }
    
        $html .= '</div></span>';
        return $html;
    }
    
    private function getDataAttributes($data) {
        $attributes = '';
    
        if (!empty($data) && is_array($data)) {
            foreach ($data as $key => $value) {
                $attributes .=  htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
            }
        }
    
        return $attributes;
    }

    public function showStatus($status_name){
        $element = [
            'Active'    => ['title' => 'Active',    'class' => 'bg-success'],
            'Pending'   => ['title' => 'Pending',   'class' => 'bg-warning'],
            'Suspended' => ['title' => 'Suspended', 'class' => 'bg-danger'],
            'Deleted'   => ['title' => 'Deleted',   'class' => 'bg-secondary']
        ];

        if (!array_key_exists($status_name, $element)) {
            return "<span class='badge bg-light'>Unknown</span>";
        }

        return "<span class='badge {$element[$status_name]['class']}'>{$element[$status_name]['title']}</span>";
    }

    public function saveFile($fileBase64, $path)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $fileBase64, $type)) {
            $image = substr($fileBase64, strpos($fileBase64, ',') + 1);
            $extension = strtolower($type[1]); // jpg, png, etc.

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                return null; // Tipo de imagen no válido
            }

            $image = base64_decode($image);
            if ($image === false) {
                return null; // Error al decodificar
            }

            $fileName = Str::random(10) . '.' . $extension;
            $filePath = 'uploads/' . trim($path, '/') . '/' . $fileName;

            // Guardar en disco "public" (storage/app/public/)
            Storage::disk('public')->put($filePath, $image);

            // Retornar ruta accesible
            return asset('storage/' . $filePath);
        }

        return null; // Formato inválido
    }
    
}
