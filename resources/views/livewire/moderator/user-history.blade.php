<div>
    <x-first-navigation-bar/>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-blog-link/>
        </div>
    </div>

    <a href="{{ route('moderator.reports') }}" class="ml-14 text-[18px] text-gray-800 hover:text-gray-600 font-semibold">
        < {{ __('Return') }}
    </a>

    <div class="mt-1 bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <div class="max-w-6xl mx-auto bg-white shadow-md rounded p-6 mt-4 mb-4 relative">
            <div class="absolute top-0 right-0 mt-2 mr-2">
                <a href="{{ route('moderator.user-history.pdf', ['user' => $userId]) }}"
                   class="flex flex-col items-center justify-center text-gray-800 hover:text-gray-600 font-semibold text-[17px]">
                    <div class="flex items-center justify-center bg-[#F8F8F8] hover:bg-[#B6D5E9] w-14 h-14 rounded-full">
                        <img src="{{ asset('storage/icons/pdf.png') }}" class="h-10 w-10">
                    </div>
                    {{__('Download PDF')}}
                </a>
            </div>

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
                            <td class="border p-2">
                                <x-date :date="$report->created_at" />
                            </td>
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
                <table class="w-full border-collapse border border-gray-300 mt-3">
                    <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">{{__('Title')}}</th>
                        <th class="border p-2">{{__('State')}}</th>
                        <th class="border p-2">{{__('Date')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr class="text-center">
                            <td class="border p-2">{{ $post->id }}</td>
                            <td class="border p-2">
                                <a href="{{ route('posts.show', $post->id) }}"
                                   class="text-blue-600 hover:underline hover:text-blue-800 transition duration-150 ease-in-out">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td class="border p-2">
                                @if ($post->trashed())
                                    <span class="text-red-500 font-semibold">
                                    {{__('Deleted')}}
                                </span>
                                @else
                                    <span class="text-green-500 font-semibold">
                                    {{__('Asset')}}
                                </span>
                                @endif
                            </td>
                            <td class="border p-2">
                                <x-date :date="$post->created_at" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

            <h2 class="text-lg font-semibold text-gray-700 mt-6">
                {{__('User Comments')}}
            </h2>
            @if ($comments->isEmpty())
                <p class="text-gray-600 italic mt-2">
                    {{__('This user has not commented.')}}
                </p>
            @else
                <table class="w-full border-collapse border border-gray-300 mt-3">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">ID</th>
                            <th class="border p-2">{{__('Comments')}}</th>
                            <th class="border p-2">{{__('Post')}}</th>
                            <th class="border p-2">{{__('State')}}</th>
                            <th class="border p-2">{{__('Date')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr class="text-center">
                                <td class="border p-2">{{ $comment->id }}</td>
                                <td class="border p-2">{{ $comment->content }}</td>
                                <td class="border p-2">
                                    <a href="{{ route('posts.show', $comment->post_id) }}"
                                       class="text-blue-600 hover:underline hover:text-blue-800">
                                        {{ $comment->post->id }}: {{ $comment->post->title }}
                                    </a>
                                </td>
                                <td class="border p-2">
                                    @if ($comment->trashed() || ($comment->parent && $comment->parent->trashed()))
                                        <span class="text-red-500 font-semibold">
                                            {{__('Deleted')}}
                                        </span>
                                            @else
                                                <span class="text-green-500 font-semibold">
                                            {{__('Asset')}}
                                        </span>
                                    @endif
                                </td>
                                <td class="border p-2">
                                    <x-date :date="$comment->created_at" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
