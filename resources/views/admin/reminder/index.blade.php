@extends('layouts.defaults.main')
@section('title', 'List Pengingat')
@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.user.index') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                        clip-rule="evenodd" />
                                </svg>

                                Pengguna
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                    aria-current="page">Pengingat</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Judul
                            </th>
                            <th scope="col"
                                class="max-w-sm p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Pesan
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Date of
                                Tanggal</th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Waktu</th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Tipe</th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Status</th>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($reminders as $reminder)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $reminder->title }}
                                    </td>
                                    <td class="max-w-sm p-4 overflow-hidden text-base font-normal text-gray-500 truncate xl:max-w-xs dark:text-gray-400">
                                        {{ $reminder->message }}
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $reminder->reminder_date }}</td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $reminder->reminder_time }}</td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $reminder->type }}</td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $reminder->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
