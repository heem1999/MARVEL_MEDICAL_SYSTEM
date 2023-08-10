
<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <button wire:click="dincrement">+</button>
    <input type="text" wire:model.lazy="message">

    <h1>{{ $message }}</h1>
</div>

