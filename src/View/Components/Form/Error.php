<?php

namespace Eclipse\Core\View\Components\Form;

use Illuminate\View\Component;

class Error extends Component
{
    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return <<<'blade'
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        @if( ! $loop->first)
                            <hr>
                        @endif
                        <p @if($loop->last) class="mb-0" @endif>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        blade;
    }
}
