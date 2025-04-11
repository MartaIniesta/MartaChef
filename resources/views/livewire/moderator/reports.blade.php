<div>
    <x-first-navigation-bar/>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center py-8 space-x-8">
            <x-nav.nav-blog-link/>
        </div>
    </div>

    <div class="flex flex-1 min-h-screen bg-[#FBFBFB] border-t-4 border-dotted border-[#B6D5E9]">
        <x-nav.moderate-browser/>

        <div class="flex-1 container mx-auto mb-2 ml-2 mr-2">
            <div class="w-48 mx-auto pt-6">
                <h1 class="text-2xl text-[#393939] font-bold text-center mb-6 mt-5 border-y-2 border-[#343434] py-3">
                    {{__('USER REPORTS')}}
                </h1>
            </div>

            <div class="text-right mb-4">
                <button wire:click="deleteReviewedReports" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    {{ __('Delete Reviewed Reports') }}
                </button>

                @if ($deleteMessage)
                    <div
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 3000)"
                        x-show="show"
                        class="mt-2 text-sm text-gray-700 whitespace-pre-line"
                    >
                        {{ $deleteMessage }}
                    </div>
                @endif
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-[#EDEDED]">
                    <th class="border p-2">{{__('Reported')}}</th>
                    <th class="border p-2">{{__('Reported by')}}</th>
                    <th class="border p-2">{{__('Reason')}}</th>
                    <th class="border p-2">{{__('State')}}</th>
                    <th class="border p-2">{{__('Record')}}</th>
                    <th class="border p-2">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($reports as $report)
                    <tr class="text-center">
                        <td class="border py-3">{{ $report->reported->name }}</td>
                        <td class="border py-3">{{ $report->reporter->name }}</td>
                        <td class="border py-3 px-1 break-words max-w-xs">{{ $report->reason }}</td>
                        <td class="border py-3">{{ ucfirst($report->status) }}</td>
                        <td class="border py-3">
                            <a href="{{ route('moderator.user-history', $report->reported->id) }}" class="text-blue-500 hover:underline">
                                {{__('View history')}}
                            </a>
                        </td>
                        <td class="border py-3 space-x-2">
                            @if($report->status === 'pending')
                                <button wire:click="markAsReviewed({{ $report->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    {{__('Revised')}}
                                </button>
                            @endif
                            <button wire:click="deleteReport({{ $report->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                {{__('Delete')}}
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
