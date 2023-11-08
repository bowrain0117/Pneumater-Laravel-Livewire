<x-app-layout>
    <h3 class="text-gray-700 text-3xl font-medium">Pneumatici - Import</h3>

    <form action="{{ route('tires.importSubmit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mt-4">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">File</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                File di pneumatici nuovi da importare.
                            </p>
                            @if ($errors->any())
                                <div class="mt-2a">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-3 bg-gray-50 sm:px-6">
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="col-span-12 sm:col-span-6 sm:text-right">
                                        <b>Template</b>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 sm:text-left">
                                        <a href="{{ asset("/templates/nuovi_pneumatici.csv") }}">
                                            <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 border border-indigo-700 rounded" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12">
                                        <hr />
                                    </div>
                                    <div class="col-span-4 sm:col-span-4">
                                        <input id="delete_tires" name="delete_tires" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="delete_tires" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rimuovi pneumatici non presenti nel file</label>
                                    </div>
                                    <div class="col-span-8 sm:col-span-8">
                                        <input type="file" name="csv" id="csv">
                                        <button type="submit"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Importa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
