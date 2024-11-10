@extends('layouts.defaults.main')
@section('title', 'List Log')
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
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Log</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">List Log Aktivitas</h1>
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="{{ route('admin.user.summaries', $id) }}" method="GET">
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96 inline-flex">
                            <input type="date" name="first_date" id="first-date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Tanggal Awal" value="{{ $firstDate }}">
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 inline-flex">sampai</p>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96 inline-flex">
                            <input type="date" name="last_date" id="last-date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Tanggal Akhir" value="{{ $lastDate }}">
                        </div>
                        <button type="submit"
                            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 inline-flex items-center justify-center">
                            Cari
                        </button>
                    </form>
                </div>
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
                                Tanggal
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Catatan Makan
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Catatan Minum</th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Aktivitas Fisik</th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Tekanan Darah</th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Obat Dikonsumsi</th>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($dates as $date => $logs)
                                @php
                                    $log = collect($logs);
                                @endphp
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($log['food_logs']['foods']->count() > 0)
                                            <ul
                                                class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                                @foreach ($log['food_logs']['foods'] as $food)
                                                    <li>{{ $food['food_name'] }} - {{ $food['calories'] }} kcal</li>
                                                @endforeach
                                                <hr>
                                                <li>Total Kalori: {{ $log['food_logs']['total_calories'] }}</li>
                                            </ul>
                                        @else
                                            <p class="text-gray-500 dark:text-gray-400">Tidak ada catatan</p>
                                        @endif
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($log['drinklogs']['drinks']->count() > 0)
                                            <ul
                                                class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                                @foreach ($log['drinklogs']['drinks'] as $food)
                                                    <li>{{ $food['drink_name'] }}</li>
                                                @endforeach
                                                <hr>
                                                <li>Total Minum: {{ $log['drinklogs']['total_amount'] }}</li>
                                            </ul>
                                        @else
                                            <p class="text-gray-500 dark:text-gray-400">Tidak ada catatan</p>
                                        @endif
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($log['exercise_logs']->count() > 0)
                                            <ul
                                                class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                                @foreach ($log['exercise_logs'] as $exercise)
                                                    <li>{{ $exercise['exercise_name'] }} - {{ $exercise['duration'] }} -
                                                        {{ $exercise['calories_burned'] }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-gray-500 dark:text-gray-400">Tidak ada catatan</p>
                                        @endif
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($log['blood_pressure']->count() > 0)
                                            <ul
                                                class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                                @foreach ($log['blood_pressure'] as $bloodPressure)
                                                    <li>{{ $bloodPressure['summary'] }} -
                                                        {{ $bloodPressure['created_at'] }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-gray-500 dark:text-gray-400">Tidak ada catatan</p>
                                        @endif
                                    </td>
                                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($log['medicine_logs']->count() > 0)
                                            <ul
                                                class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                                @foreach ($log['medicine_logs'] as $medicine)
                                                    <li>{{ $medicine['summary'] }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-gray-500 dark:text-gray-400">Tidak ada catatan</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
