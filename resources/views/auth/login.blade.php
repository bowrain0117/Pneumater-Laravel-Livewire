<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <svg class="mx-auto h-10 w-auto" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 511.999 511.999" class="h-12 w-12 fill-current text-indigo-400 mr-2"
                 xml:space="preserve">
                <g>
                    <g>
                        <path d="M293.6,230.954c-13.81,0-25.045,11.235-25.045,25.045c0,13.81,11.235,25.045,25.045,25.045s25.045-11.235,25.045-25.045
                            C318.645,242.189,307.41,230.954,293.6,230.954z"></path>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M310.189,155.037v45.163c12.862,3.83,23.872,11.989,31.333,22.788l42.956-13.958
                C369.869,180.878,342.56,160.336,310.189,155.037z"></path>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M394.754,240.574l-42.969,13.962c0.012,0.488,0.038,0.973,0.038,1.463c0,13.297-4.49,25.558-12.02,35.371l26.53,36.514
                c18.279-18.492,29.583-43.892,29.583-71.885C395.916,250.757,395.518,245.606,394.754,240.574z"></path>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M293.6,37.6H91.789c-9.161,0-16.588,7.427-16.588,16.588s7.427,16.588,16.588,16.588h86.226
                c-18.192,11.393-34.595,25.385-48.68,41.46H16.588C7.427,112.237,0,119.665,0,128.826c0,9.161,7.427,16.588,16.588,16.588h88.75
                c-19.138,32.456-30.138,70.258-30.138,110.585c0,46.924,14.879,90.438,40.161,126.077H68.295c-9.161,0-16.588,7.427-16.588,16.588
                c0,9.161,7.427,16.588,16.588,16.588h76.019c10.343,9.702,21.628,18.408,33.701,25.969H18.299
                c-9.161,0-16.588,7.427-16.588,16.588c0,9.161,7.427,16.588,16.588,16.588H293.6c120.427,0,218.399-97.974,218.399-218.399
                S414.026,37.6,293.6,37.6z M374.178,364.859c-0.305,0.258-0.608,0.518-0.937,0.755c-0.37,0.269-0.749,0.52-1.132,0.754
                c-22.164,15.811-49.269,25.123-78.509,25.123c-29.24,0-56.344-9.312-78.509-25.123c-0.384-0.234-0.762-0.485-1.132-0.754
                c-0.328-0.239-0.631-0.499-0.937-0.755c-33.295-24.71-54.915-64.306-54.915-108.86c0-74.711,60.782-135.493,135.493-135.493
                s135.493,60.782,135.493,135.493C429.093,300.554,407.474,340.149,374.178,364.859z"></path>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M202.722,209.029l42.955,13.958c7.463-10.798,18.472-18.957,31.334-22.788v-45.163
                C244.641,160.336,217.332,180.877,202.722,209.029z"></path>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M312.979,310.894c-6.066,2.148-12.585,3.329-19.379,3.329c-6.792,0-13.313-1.181-19.379-3.329l-26.536,36.522
                c13.816,6.967,29.414,10.899,45.915,10.899s32.099-3.931,45.915-10.899L312.979,310.894z"></path>
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M235.378,255.999c0-0.49,0.024-0.975,0.036-1.463l-42.969-13.962c-0.764,5.032-1.162,10.183-1.162,15.425
                c0,27.994,11.305,53.394,29.584,71.887l26.53-36.516C239.868,281.558,235.378,269.296,235.378,255.999z"></path>
                    </g>
                </g>
            </svg>
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Pneumater</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                               autocomplete="email" autofocus
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="text-sm">
                            {{-- <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a> --}}
                        </div>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            {{--
            <p class="mt-10 text-center text-sm text-gray-500">
                Not a member?
                <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Start a 14 day free
                    trial</a>
            </p>
            --}}
        </div>
    </div>
</x-guest-layout>
