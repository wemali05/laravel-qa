@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        Ask Question
                        <div class="ml-auto">
                            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to All
                                Questions</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts._message')

                    <form action="{{ route('questions.store') }}" method="POST">
                        @include('questions._form', ['buttonText' => "Add Questiom"])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection