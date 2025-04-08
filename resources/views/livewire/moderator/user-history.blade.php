<div class="mt-1 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded p-6 mt-4 mb-4">

        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            {{__('User History')}}: {{ $user->name }}
        </h1>

        <h2 class="text-lg font-semibold text-gray-700 mt-4">
            {{__('Reports Received')}}
        </h2>
        @if ($reports->isEmpty())
            <p class="text-gray-600 italic mt-2">
                {{__('This user has not been reported.')}}
            </p>
        @else
            <table class="w-full border-collapse border border-gray-300 mt-3">
                <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">{{__('Reported by')}}</th>
                    <th class="border p-2">{{__('Reason')}}</th>
                    <th class="border p-2">{{__('State')}}</th>
                    <th class="border p-2">{{__('Date')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($reports as $report)
                    <tr class="text-center">
                        <td class="border p-2">{{ $report->reporter->name }}</td>
                        <td class="border p-2 break-words max-w-xs">{{ $report->reason }}</td>
                        <td class="border p-2">{{ ucfirst($report->status) }}</td>
                        <td class="border p-2">{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <h2 class="text-lg font-semibold text-gray-700 mt-6">
            {{__('User Posts')}}
        </h2>
        @if ($posts->isEmpty())
            <p class="text-gray-600 italic mt-2">
                {{__('This user has no published recipes.')}}
            </p>
        @else
            <ul class="list-disc ml-6 mt-2">
                @foreach ($posts as $post)
                    <li class="border-b py-2">
                        <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:underline hover:text-blue-800 transition duration-150 ease-in-out">
                            {{ $post->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <h2 class="text-lg font-semibold text-gray-700 mt-6">
            {{__('User Comments')}}
        </h2>
        @if ($comments->isEmpty())
            <p class="text-gray-600 italic mt-2">
                {{__('This user has not commented.')}}
            </p>
        @else
            <ul class="list-disc ml-6 mt-2">
                @foreach ($comments as $comment)
                    <li class="border-b py-2">
                        <a href="{{ route('posts.show', $comment->post_id) }}" class="text-blue-600 hover:underline hover:text-blue-800 transition duration-150 ease-in-out"
                            title="Ver post: {{ $comment->post->title }}">
                            {{ $comment->content }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
