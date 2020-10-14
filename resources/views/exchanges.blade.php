<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exchanges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 mb-5">
                <form method="POST">
                    @csrf
                    <input name="amount" placeholder="Amount" type="number" min="0.00" max="1000000.00" step="0.01" style="border: solid 1px #ccc; padding: 4px 15px;" />
                    <select name="currency" style="padding: 5px 15px;">
                        @foreach($currencies as $currencyFrom)
                            @foreach($currencies as $currencyTo)
                                @if($currencyFrom->id != $currencyTo->id)
                                    <option value="{{ $currencyFrom->code . '-' . $currencyTo->code }}">
                                        {{ $currencyFrom->code . ' - ' . $currencyTo->code }}
                                    </option>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                    <button style="background: #187bcd; color: #fff; padding: 5px 15px">
                        Convert
                    </button>
                </form>
                <hr class="my-3" />
                @if(count($exchanges) > 0)
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exchanges as $exchange)
                                <tr>
                                    <td class="text-center">
                                        @if(date('Y-m-d') == date('Y-m-d', strtotime($exchange->created_at)))
                                            {{ date('h:i A', strtotime($exchange->created_at)) }}
                                        @elseif(date('Y') == date('Y', strtotime($exchange->created_at)))
                                            {{ date('d/m h:i A', strtotime($exchange->created_at)) }}
                                        @else
                                            {{ date('d/m/y h:i A', strtotime($exchange->created_at)) }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($exchange->amount, 2) }}
                                        {{ $exchange->currencyFrom->code }}
                                        -
                                        {{ number_format($exchange->amount * $exchange->rate, 2) }}
                                        {{ $exchange->currencyTo->code }}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($exchange->rate, 5) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $exchange->user->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No exchanges found.</p>
                @endif
            </div>
            {{ $exchanges->links() }}
        </div>
    </div>
</x-app-layout>
