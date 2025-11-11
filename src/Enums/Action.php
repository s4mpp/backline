<?php

namespace S4mpp\Backline\Enums;

enum Action: string
{
    case Create = 'create';
    case Read = 'read';
    case Update = 'update';
    case Delete = 'delete';
    case Duplicate = 'duplicate';

    public function title(): string
    {
        return match ($this) {
            self::Create => 'Cadastrar',
            self::Read => 'Visualizar',
            self::Update => 'Editar',
            self::Delete => 'Excluir',
            self::Duplicate => 'Duplicar',
        };
    }
}
