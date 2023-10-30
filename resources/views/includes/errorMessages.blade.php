@if(session()->has('errors'))
    <script>
        window.onload = function() {
            @foreach(session('errors') as $key => $error)
                setTimeout(function() {
                    M.toast({html: '<strong>{{ $error }}</strong>', classes: 'rounded red'});
                }, {{ $key }} * 300);
            @endforeach
        }
    </script>
@endif
