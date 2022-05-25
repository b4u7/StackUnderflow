@component('mail::message')
**Someone answered your question**

# {{ $answer->question->title }}

@component('mail::panel')
    {{ Str::limit($answer->body, 200) }}
@endcomponent

@component('mail::button', ['url' => route('questions.show', $answer->question_id)])
    Read More
@endcomponent

@component('mail::subcopy')
    If you're having trouble clicking the "Read More" button, copy and paste the URL below into your web browser: [{{ route('questions.show', $answer->question_id) }}]({{ route('questions.show', $answer->question_id) }})
@endcomponent
@endcomponent
