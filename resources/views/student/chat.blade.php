@extends('layouts.base')

@section('title', 'Chat - Student Dashboard')

@section('main')
    <div class="px-8 py-12 space-y-5">
        <h1 class="text-xl font-bold">Chat</h1>

        <div class="flex h-[400px] text-sm border rounded-xl">
            @if (count($users) > 0)
                <ul class="flex-[1] [&>li]:p-3.5 flex flex-col overflow-y-auto gap-y-2 [&>li]:rounded-md border-r p-2.5">
                    <li
                        class="@if (Request::get('with') == 'ai') bg-gray-800 text-white font-medium
                            @else bg-gray-100 @endif">
                        <a href="{{ Request::url() . '?with=ai' }}" class="flex items-center gap-x-2.5">
                            SchoolManagement <small
                                class="w-6 h-6 font-bold grid place-items-center rounded-full bg-[#577590] text-white">AI</small>
                        </a>
                    </li>
                    @foreach ($users as $user)
                        <li
                            class="@if (Request::get('with') == $user->id) bg-gray-800 text-white font-medium
                            @else bg-gray-100 @endif">
                            <a href="{{ Request::url() . '?with=' . $user->id }}">
                                {{ $user->name }} ({{ ucwords(str_replace('_', ' ', $user->role)) }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No users available.</p>
            @endif


            <div class="p-2.5 flex-[3] flex flex-col">
                <div class="mt-auto"></div>
                @if (Request::has('with'))
                    <ul id="messages" class="flex flex-col gap-y-2 overflow-y-scroll">
                        @foreach ($messages as $message)
                            @if ($message->from_user === Auth::id())
                                <li class="to-user">
                                    {{ $message->content }}
                                </li>
                            @else
                                <li class="from-user">
                                    {{ $message->content }}
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    @if (Request::get('with') === 'ai')
                        <form id="ai-form"
                            class="mt-3.5 flex gap-x-2 w-full [&>input]:w-full [&>input]:px-2.5 [&>input]:py-2 [&>input]:border [&>input]:rounded-md">
                            <input type="text" name="content" id="content" placeholder="Your message...">
                            <button type="submit" class="bg-gray-950 text-white font-medium rounded-md p-2">Send</button>
                        </form>

                        @push('body_scripts')
                            <script>
                                document.querySelector('#ai-form').addEventListener('submit', async (e) => {
                                    e.preventDefault()

                                    let content = e.target.elements['content'].value

                                    if (content !== '') {
                                        axios.post('http://127.0.0.1:5000/chat', {
                                                message: content
                                            })
                                            .then((res) => {
                                                const li = document.createElement('li')
                                                li.textContent = content
                                                li.classList.add('to-user')

                                                const li1 = document.createElement('li')
                                                li1.textContent = res.data?.message
                                                li1.classList.add('from-user')

                                                messages.appendChild(li)
                                                messages.appendChild(li1)
                                                messages.scrollTo(0, messages.scrollHeight)
                                            }).catch((error) => {
                                                console.log(error)
                                            })
                                    }

                                    e.target.reset()
                                })
                            </script>
                        @endpush
                    @else
                        <form id="message-form"
                            class="mt-3.5 flex gap-x-2 w-full [&>input]:w-full [&>input]:px-2.5 [&>input]:py-2 [&>input]:border [&>input]:rounded-md">
                            <input type="text" name="content" id="content" placeholder="Your message...">
                            <button type="submit" class="bg-gray-950 text-white font-medium rounded-md p-2">Send</button>
                        </form>

                        @push('head_scripts')
                            <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
                        @endpush

                        @push('body_scripts')
                            <script defer>
                                const socket = io('ws://localhost:3000', {
                                    transports: ['websocket']
                                })

                                const messages = document.querySelector('#messages')
                                socket.on('chat_message', (payload) => {
                                    const li = document.createElement('li')
                                    li.textContent = payload?.content
                                    li.classList.add(payload?.from_user == '{{ Auth::id() }}' ? 'to-user' : 'from-user')
                                    messages.appendChild(li)
                                    messages.scrollTo(0, messages.scrollHeight)
                                });

                                document.querySelector('#message-form').addEventListener('submit', (e) => {
                                    e.preventDefault()

                                    let content = e.target.elements['content'].value

                                    if (content !== '') {
                                        socket.emit('chat_message', {
                                            from_user: "{{ Auth::id() }}",
                                            to_user: "{{ Request::get('with') }}",
                                            content: content
                                        })
                                    }

                                    e.target.reset()
                                })
                            </script>
                        @endpush
                    @endif
                @else
                    <p class="h-full grid place-items-center">Select a contact to continue.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
