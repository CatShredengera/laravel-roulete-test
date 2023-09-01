<!-- resources/views/main.blade.php -->
@extends('layout')

@section('title', 'Main Page')

@section('content')
    <div>
        <h2 class="mt-4 text-center">Main Page</h2>
        <p class="mb-4 text-center">Your unique link: <a class="text-white" href="{{ $link }}">{{ $link }}</a></p>

        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <form method="post" action="{{ route('deactivate.link', ["token" => $link]) }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block">Deactivate Link</button>
                </form>

                <form method="post" action="{{ route('regenerate.link', ["token" => $link]) }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">Regenerate Link</button>
                </form>

                <form method="post" action="{{ route('play.random', ["token" => $link]) }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success btn-block">I'm Feeling Lucky</button>
                </form>

                <form method="get" action="{{ route('history', ["token" => $link]) }}" class="mb-3">
                    <button type="submit" class="btn btn-info btn-block">History</button>
                </form>
                @if(session('randomResult'))
                    <h3 class="mt-4">Random Result:</h3>
                    <p>Number: {{ session('randomResult.number') }}</p>
                    <p>Result: {{ session('randomResult.result') }}</p>
                    @if(session('randomResult.result') === 'Win')
                        <p>Win Amount: {{ session('randomResult.winAmount') }}</p>
                    @endif
                @endif

                @if(isset($history))
                    <h3 class="mt-4">Last 3 Game Results:</h3>
                    <ul>
                        @foreach($history as $result)
                            <li>{{ $result->result }} - Amount: {{ $result->amount }}</li>
                        @endforeach
                    </ul>
                @endif

                @if(isset($results))
                    <h3 class="mt-4">Your Game Results:</h3>
                    <ul>
                        @foreach($results as $result)
                            <li>{{ $result->result }} - Amount: {{ $result->amount }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
