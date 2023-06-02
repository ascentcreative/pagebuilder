<form method="POST" action="{{ url()->current() }}">

    @csrf

    <x-forms-fields-input type="text" name="content[12345][abcde][text]" label="abcde" value="abcde"/>

    <x-forms-fields-input type="text" name="content[12345][text]" label="12345" value="12345"/>

    <x-forms-fields-input type="text" name="content[10000][text]" label="10000" value="10000"/>

    <x-forms-fields-input type="text" name="content[020202][text]" label="020202" value="020202"/>

    <button>OK</button>

</form>

