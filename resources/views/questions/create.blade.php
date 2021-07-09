@extends('app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns is-gapless mb-0">
                <div class="column">
                    <div class="content">
                        <h1>
                            Ask a question
                        </h1>
                    </div>
                </div>
                <div class="column">
                    <div class="buttons has-text-weight-bold is-right">
                        <a class="button is-primary is-uppercase" href="{{ route('questions.index') }}">
                            Go back
                        </a>
                    </div>
                </div>
            </div>
            <div class="box mt-0">
                <form action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label class="label">
                            Title
                        </label>
                        <div class="control">
                            <input class="input" type="text" name="title" placeholder="Title">
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
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var easyMDE = new EasyMDE({
                element: document.getElementById('emde'),
                placeholder: 'Type here...',
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
