<?php

use Livewire\Volt\Component;

new class extends Component {
    public $entry;
    public $date;
}; ?>

<div>
    {{ $entry }}
    {{ $date }}
</div>
