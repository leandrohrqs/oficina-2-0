@if(session()->has('success'))
    <script>
        window.onload = function() {
            @foreach(session('success') as $key => $success)
                setTimeout(function() {
                    M.toast({html: '<strong>{{ $success }}</strong>', classes: 'rounded green'});
                }, {{ $key }} * 300);
            @endforeach
        }
    </script>
@endif  
