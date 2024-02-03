<?php

use Eclipse\Core\Framework\Output;

test('toasts can be added', function () {
    /** @var Output $output */
    $output = app(Output::class);

    expect($output->getToasts())->toBeEmpty();

    $toast = $output->toast('Some toast message');

    expect($toast->getMessage())->toEqual('Some toast message');

    expect(count($output->getToasts()))->toEqual(1);
});
