@extends('app')

@section('content')
    <div class="container">
        <div class="buttons has-text-weight-bold is-right">
            <a class="button is-primary is-uppercase" href="{{ route('questions.show', $question->id) }}">
                Go back
            </a>
        </div>
        <div class="box">
            <form id="form" action="{{ route('questions.update', [$question]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="field">
                    <label class="label">
                        Title
                    </label>
                    <div class="control">
                        <input class="input" type="text" name="title" placeholder="Title"
                               value="{{ $question->title }}">
                    </div>
                </div>
                <div class="field">
                    <label class="label">
                        Body
                    </label>
                    <div class="control">
                        <textarea id="emde" class="textarea" name="body"></textarea>
                    </div>
                </div>
                <div class="field is-grouped is-grouped-multiline">
                    <div class="control">
                        <div class="tags">
                            <input id="tags"
                                   class="input"
                                   type="text"
                                   name="tags"
                                   data-type="tags"
                                   placeholder="Choose Tags"
                                   value="{{ implode(",", $tags) }}"
                            >
                        </div>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary is-uppercase">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var easyMDE = new EasyMDE({
                element: document.getElementById('emde'),
                placeholder: 'Type here...',
                initialValue: @json($question->body),
                hideIcons: ["guide", "fullscreen", "side-by-side"],
                tabSize: 4
            });

            const tagsInput = document.getElementById('tags');
            new BulmaTagsInput(tagsInput, {
                delimiter: ','
            });
        }, false);
    </script>
@endpush
