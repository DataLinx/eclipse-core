<x-app-layout>

    <x-slot name="header">
        <h1>
            Visual component test
        </h1>
    </x-slot>

    <div class="container">

        <h2>Form inputs</h2>

        <h3>Common input</h3>

        <x-form::input name="foo" label="Standard text" help="Help text" required placeholder="Placeholder" />

        <x-form::input name="foo" label="Different sizes" placeholder="size=sm" size="sm" />
        <x-form::input name="foo" placeholder="normal size" />
        <x-form::input name="foo" placeholder="size=lg" size="lg" />

        <x-form::input name="foo" label="With prepended and appended content" required placeholder="domain" size="sm" prepend="www." append=".com" />

        <h4>Textarea</h4>
        <x-form::textarea name="foo" label="Simple example" help="Help text" required placeholder="Placeholder text..." rows="6" />

        <h3>Checkbox</h3>

        <x-form::checkbox :name="uniqid('cb-')" :options="['one', 'two']" label="Standard checkbox" required help="Some help text" />

        <x-form::checkbox :name="uniqid('cb-')" :options="['one', 'two']" label="Displayed as small buttons" as-buttons size="sm" />

        <x-form::checkbox :name="uniqid('cb-')" :options="['one', 'two']" label="Displayed as normal-sized buttons" as-buttons help="Some help text" />

        <x-form::checkbox :name="uniqid('cb-')" :options="['one', 'two']" label="Displayed as large buttons" as-buttons size="lg" />

        <x-form::checkbox :name="uniqid('cb-')" :options="['one', 'two']" label="Displayed as switches" help="Some help text" as-switches default="0" />

        <h3>Radio</h3>

        <x-form::radio :name="uniqid('cb-')" :options="['one', 'two']" label="Standard radio buttons" required help="Some help text" />

        <x-form::radio :name="uniqid('cb-')" :options="['one', 'two']" label="Displayed as buttons" help="Some help text" as-buttons />

        <h3>Simple switcher</h3>

        <x-form::switcher name="foo" label="Bar" default="1" help="Help text" id="some-id" required />

        <h3>File</h3>

        <x-form::file name="foo" label="File selector example" help="Help text" required />

        <h3>Select</h3>

        <x-form::select name="foo" label="Common example" :options="['One', 'Two', 'Three']" default="2" help="Help text" required placeholder="Placeholder" />

        <x-form::select name="foo" label="Example without options" placeholder="Placeholder" />

        <x-form::select name="foo" label="Option groups" :options="['Group One' => [
                    1 => 'Option One',
                    2 => 'Option Two',
                ],
                'Group Two' => [
                    3 => 'Option Three',
                    4 => 'Option Four',
                ],
                5 => 'Non-grouped Option Five']" />

        <x-form::select name="foo" label="Multiple choices" :options="['One', 'Two', 'Three']" multiple />

        <h3>Static plain text</h3>

        <x-form::plaintext label="Basic example" id="some-id">Foo</x-form::plaintext>

        <x-form::plaintext>
            <x-slot name="label">Example with HTML <b>label</b></x-slot>
            Bar
        </x-form::plaintext>

        <h2>Alerts</h2>

        <x-alert>
            <p>This is the minimal example.</p>
        </x-alert>

        <x-alert type="success">
            <p>Example with type "success"</p>
        </x-alert>

        <x-alert heading="Example with heading" type="warning">
            <p>The queen is accelerative harmless. Red alert, attitude! Resist without x-ray vision, and we won’t examine a machine.</p>
        </x-alert>

        <x-alert heading="Dismissible example" type="danger" dismissible>
            <p>This one can be dismissed!</p>
        </x-alert>

        <h2>Icons</h2>

        <p>
            This is a simple inline user icon <x-icon name="user"/> in a paragraph.
        </p>

        <x-form::plaintext label="Example with all options:">
            <x-icon name="heart" pack="fal" color="danger" class="fa-5x fa-beat" id="some-id" />
        </x-form::plaintext>


    </div>

</x-app-layout>
