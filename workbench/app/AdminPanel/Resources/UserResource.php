<?php

namespace Workbench\App\AdminPanel\Resources;

use S4mpp\AdminPanel\Form\Input;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Enums\Action;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\AdminPanel\Builders\FormBuilder;
use S4mpp\AdminPanel\Builders\ReadBuilder;
use S4mpp\AdminPanel\Builders\TableBuilder;

final class UserResource extends Resource
{
    protected static string $title = 'Itens básicos';

    protected static string $label = 'title';

    // protected static array $actions = [Action::Create, Action::Read, Action::Update, Action::Delete, Action::Duplicate];

    // public function table(TableBuilder $table): void
    // {
    //     $table->searchBy('Título', 'title');
    //     $table->searchBy('Texto básico', 'basic_text')->exact();

    //     $table->columns(
    //         new Text('Nome', 'name'),
    //         new Text('E-mail', 'email'),
    //     );
    // }

    // public function read(ReadBuilder $read): void
    // {
    //     $read->labels(
    //         new Text('Nome', 'name'),
    //         new Text('E-mail', 'email'),
    //     );
    // }

    // public function form(FormBuilder $form): void
    // {
    //     $form->fields(
    //         new Input('Nome', 'name'),
    //         new Input('E-mail', 'email'),
    //     );
    // }
}
