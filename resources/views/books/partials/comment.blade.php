<div class="bg-white rounded-xl shadow-md p-5">
    <div class="flex gap-4">
        <div class="flex-shrink-0">
            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                <span class="text-purple-600 font-semibold text-sm">
                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                </span>
            </div>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <span class="font-medium text-gray-800">{{ $comment->user->name ?? 'Pengguna' }}</span>
                <span class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-gray-700">{{ $comment->body }}</p>
            
            @auth
                <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="mt-2 text-sm text-purple-600 hover:text-purple-800">
                    Balas
                </button>
                
                <!-- Reply Form -->
                <form id="reply-form-{{ $comment->id }}" method="POST" action="{{ route('comments.store', $comment->book) }}" class="hidden mt-3">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="body" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-purple-500 focus:ring-purple-500" placeholder="Tulis balasan..." required></textarea>
                    <div class="mt-2 flex gap-2">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-1 rounded-full text-sm font-medium transition-colors">
                            Kirim
                        </button>
                        <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="text-gray-500 hover:text-gray-700 px-4 py-1 text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            @endauth

            <!-- Replies -->
            @if ($comment->replies && $comment->replies->count() > 0)
                <div class="mt-4 pl-4 border-l-2 border-purple-100 space-y-4">
                    @foreach ($comment->replies as $reply)
                        @include('books.partials.comment', ['comment' => $reply])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
