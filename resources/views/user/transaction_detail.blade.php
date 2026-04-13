@extends('layouts.app')

@section('title', 'Pembayaran - E-Ticketing Easy')
@section('page-title', 'Pembayaran')
@section('page-subtitle', 'Selesaikan pembayaran untuk pesanan Anda')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 ">Dashboard</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('booking.history') }}" class="text-gray-400 hover:text-gray-900 ">Riwayat</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Pembayaran #{{ $transaction->id }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Flight & Transaction Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Status Banner --}}
            <div class="glass-card p-5
                @if($transaction->status === 'Lunas') border-green-200 bg-green-50/50
                @elseif($transaction->status === 'Gagal') border-red-200 bg-red-50/50
                @else border-amber-200 bg-amber-50/50
                @endif">
                <div class="flex items-center gap-4">
                    @if($transaction->status === 'Lunas')
                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-green-800">Pembayaran Dikonfirmasi</h3>
                            <p class="text-sm text-green-600">Transaksi Anda telah berhasil dikonfirmasi oleh admin.</p>
                        </div>
                    @elseif($transaction->status === 'Gagal')
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-red-800">Pembayaran Ditolak</h3>
                            <p class="text-sm text-red-600">Transaksi Anda ditolak. Stok kursi telah dikembalikan.</p>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-amber-800">
                                @if($transaction->payment_proof)
                                    Menunggu Konfirmasi Admin
                                @else
                                    Menunggu Pembayaran
                                @endif
                            </h3>
                            <p class="text-sm text-amber-600">
                                @if($transaction->payment_proof)
                                    Bukti pembayaran telah diupload. Mohon tunggu konfirmasi dari admin.
                                @else
                                    Silakan upload bukti pembayaran untuk menyelesaikan transaksi.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Flight Info Card --}}
            <div class="glass-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $transaction->booking->schedule->plane_name }}</h3>
                        <p class="text-xs text-gray-500">Detail Penerbangan</p>
                    </div>
                </div>

                {{-- Visual Route --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-5">
                    <div class="flex items-center justify-between">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($transaction->booking->schedule->origin, ' (') }}</p>
                            <p class="text-sm text-blue-600 font-medium mt-1">{{ Str::between($transaction->booking->schedule->origin, '(', ')') ?: $transaction->booking->schedule->origin }}</p>
                        </div>

                        <div class="flex-1 mx-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-blue-500 border-2 border-blue-200"></div>
                                <div class="flex-1 h-[2px] bg-gradient-to-r from-blue-400 via-gray-300 to-amber-400 relative">
                                    <svg class="absolute left-1/2 -translate-x-1/2 -top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 rounded-full bg-amber-500 border-2 border-amber-200"></div>
                            </div>
                            <p class="text-center text-[10px] text-gray-400 mt-2 uppercase tracking-widest">Langsung</p>
                        </div>

                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($transaction->booking->schedule->destination, ' (') }}</p>
                            <p class="text-sm text-amber-600 font-medium mt-1">{{ Str::between($transaction->booking->schedule->destination, '(', ')') ?: $transaction->booking->schedule->destination }}</p>
                        </div>
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Tanggal</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($transaction->booking->schedule->departure)->format('d M Y') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jam</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($transaction->booking->schedule->departure)->format('H:i') }} WIB</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jumlah Kursi</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $transaction->booking->total_seats }} Kursi</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Total Bayar</p>
                        <p class="text-sm font-semibold text-accent-500 mt-1">Rp {{ number_format($transaction->amount) }}</p>
                    </div>
                </div>
            </div>

            {{-- Payment Info: QR Codes & Bank Accounts (shown when pending and no proof yet) --}}
            @if($transaction->status === 'Pending' && !$transaction->payment_proof)
                {{-- E-Wallet QR Codes --}}
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Bayar via E-Wallet</h3>
                            <p class="text-xs text-gray-500">Scan QR code di bawah dengan aplikasi e-wallet Anda</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        {{-- GoPay --}}
                        <div class="group relative p-4 rounded-2xl border-2 border-gray-100 hover:border-green-300 hover:shadow-lg hover:shadow-green-50 transition-all duration-300 cursor-pointer bg-white" onclick="showQrModal('GoPay', 'gopay')">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-200">
                                    <span class="text-white font-extrabold text-lg">G</span>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">GoPay</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Tap untuk QR</p>
                            </div>
                        </div>

                        {{-- ShopeePay --}}
                        <div class="group relative p-4 rounded-2xl border-2 border-gray-100 hover:border-orange-300 hover:shadow-lg hover:shadow-orange-50 transition-all duration-300 cursor-pointer bg-white" onclick="showQrModal('ShopeePay', 'shopeepay')">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-orange-200">
                                    <span class="text-white font-extrabold text-lg">S</span>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">ShopeePay</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Tap untuk QR</p>
                            </div>
                        </div>

                        {{-- OVO --}}
                        <div class="group relative p-4 rounded-2xl border-2 border-gray-100 hover:border-purple-300 hover:shadow-lg hover:shadow-purple-50 transition-all duration-300 cursor-pointer bg-white" onclick="showQrModal('OVO', 'ovo')">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-700 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-purple-200">
                                    <span class="text-white font-extrabold text-lg">O</span>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">OVO</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Tap untuk QR</p>
                            </div>
                        </div>

                        {{-- DANA --}}
                        <div class="group relative p-4 rounded-2xl border-2 border-gray-100 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300 cursor-pointer bg-white" onclick="showQrModal('DANA', 'dana')">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-200">
                                    <span class="text-white font-extrabold text-lg">D</span>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">DANA</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Tap untuk QR</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bank Transfer Info --}}
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Bayar via Transfer Bank</h3>
                            <p class="text-xs text-gray-500">Transfer ke salah satu rekening berikut</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        {{-- BCA --}}
                        <div class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-blue-50 to-white border border-blue-100 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shadow-blue-200">
                                    <span class="text-white font-extrabold text-xs">BCA</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Bank BCA</p>
                                    <p class="text-xs text-gray-500">a.n. PT Pinto Air Indonesia</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold font-mono text-blue-700 tracking-wider" id="bca-number">8720 5431 0098</p>
                                <button onclick="copyToClipboard('872054310098', this)" class="text-xs text-blue-500 hover:text-blue-700 font-medium mt-0.5 cursor-pointer bg-transparent border-none inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin
                                </button>
                            </div>
                        </div>

                        {{-- Mandiri --}}
                        <div class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-yellow-50 to-white border border-yellow-100 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center shadow-md shadow-yellow-200">
                                    <span class="text-white font-extrabold text-[9px] leading-tight text-center">MDR</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Bank Mandiri</p>
                                    <p class="text-xs text-gray-500">a.n. PT Pinto Air Indonesia</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold font-mono text-yellow-700 tracking-wider">1300 0215 7893</p>
                                <button onclick="copyToClipboard('130002157893', this)" class="text-xs text-yellow-600 hover:text-yellow-700 font-medium mt-0.5 cursor-pointer bg-transparent border-none inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin
                                </button>
                            </div>
                        </div>

                        {{-- BRI --}}
                        <div class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-blue-50 to-white border border-blue-100 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-700 to-blue-900 flex items-center justify-center shadow-md shadow-blue-200">
                                    <span class="text-white font-extrabold text-xs">BRI</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Bank BRI</p>
                                    <p class="text-xs text-gray-500">a.n. PT Pinto Air Indonesia</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold font-mono text-blue-800 tracking-wider">0341 0100 5678 901</p>
                                <button onclick="copyToClipboard('034101005678901', this)" class="text-xs text-blue-500 hover:text-blue-700 font-medium mt-0.5 cursor-pointer bg-transparent border-none inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin
                                </button>
                            </div>
                        </div>

                        {{-- BNI --}}
                        <div class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-orange-50 to-white border border-orange-100 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center shadow-md shadow-orange-200">
                                    <span class="text-white font-extrabold text-xs">BNI</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Bank BNI</p>
                                    <p class="text-xs text-gray-500">a.n. PT Pinto Air Indonesia</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold font-mono text-orange-700 tracking-wider">0285 6720 4431</p>
                                <button onclick="copyToClipboard('028567204431', this)" class="text-xs text-orange-500 hover:text-orange-700 font-medium mt-0.5 cursor-pointer bg-transparent border-none inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Important Note --}}
                    <div class="mt-4 p-4 rounded-xl bg-amber-50 border border-amber-200">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-amber-800">Penting!</p>
                                <p class="text-xs text-amber-700 mt-1">Transfer tepat sesuai nominal <span class="font-bold">Rp {{ number_format($transaction->amount) }}</span> agar pembayaran dapat diverifikasi dengan cepat. Pastikan upload bukti transfer setelah melakukan pembayaran.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Uploaded Payment Proof --}}
            @if($transaction->payment_proof)
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Bukti Pembayaran</h3>
                            <p class="text-xs text-gray-500">Metode: {{ $transaction->payment_method }}</p>
                        </div>
                    </div>
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="w-full max-h-96 object-contain">
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Payment Form / Summary --}}
        <div class="lg:col-span-1">
            <div class="glass-card p-6 sticky top-24">
                @if($transaction->status === 'Pending' && !$transaction->payment_proof)
                    {{-- Payment Form --}}
                    <h4 class="text-lg font-bold text-gray-900 mb-1">Upload Bukti Bayar</h4>
                    <p class="text-xs text-gray-500 mb-5">Pilih metode dan upload bukti pembayaran</p>

                    <form action="{{ route('transaction.pay', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        {{-- Payment Method --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method_select" required
                                class="input-admin w-full" onchange="updatePaymentInfo()">
                                <option value="" disabled selected>Pilih metode...</option>
                                <optgroup label="Transfer Bank">
                                    <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                    <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                    <option value="Transfer Bank BRI">Transfer Bank BRI</option>
                                    <option value="Transfer Bank BNI">Transfer Bank BNI</option>
                                </optgroup>
                                <optgroup label="E-Wallet">
                                    <option value="GoPay">GoPay</option>
                                    <option value="OVO">OVO</option>
                                    <option value="DANA">DANA</option>
                                    <option value="ShopeePay">ShopeePay</option>
                                </optgroup>
                            </select>
                        </div>

                        {{-- Quick Info based on selection --}}
                        <div id="selected-payment-info" class="hidden">
                            {{-- Dynamically shows bank account or QR info --}}
                        </div>

                        {{-- Payment Proof Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
                            <div class="relative">
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/jpeg,image/png,image/jpg" required
                                    class="hidden"
                                    onchange="previewImage(this)">
                                <label for="payment_proof" 
                                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-gray-400 hover:bg-gray-50  "
                                    id="upload-area">
                                    <div id="upload-placeholder" class="flex flex-col items-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500 font-medium">Klik untuk upload</p>
                                        <p class="text-xs text-gray-400 mt-1">JPG, JPEG, PNG (Maks 2MB)</p>
                                    </div>
                                    <img id="preview-image" src="" alt="" class="hidden w-full h-full object-contain rounded-xl p-2">
                                </label>
                            </div>
                        </div>

                        {{-- Price Summary --}}
                        <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Harga per kursi</span>
                                <span class="text-sm text-gray-700">Rp {{ number_format($transaction->booking->schedule->price) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Jumlah kursi</span>
                                <span class="text-sm text-gray-700">{{ $transaction->booking->total_seats }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                                <span class="text-sm font-semibold text-gray-900">Total Bayar</span>
                                <span class="text-xl font-bold text-accent-500">Rp {{ number_format($transaction->amount) }}</span>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-gradient-amber w-full text-center font-semibold py-3 rounded-xl text-white cursor-pointer border-none flex items-center justify-center gap-2   hover:transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload & Kirim
                        </button>
                    </form>
                @else
                    {{-- Summary (already paid or processed) --}}
                    <h4 class="text-lg font-bold text-gray-900 mb-1">Ringkasan Transaksi</h4>
                    <p class="text-xs text-gray-500 mb-5">Detail pembayaran Anda</p>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">ID Transaksi</span>
                            <span class="text-sm font-mono font-medium text-gray-900">#{{ $transaction->id }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Metode</span>
                            <span class="text-sm font-medium text-gray-900">{{ $transaction->payment_method ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Kursi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $transaction->booking->total_seats }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Status</span>
                            @if($transaction->status === 'Lunas')
                                <span class="badge badge-success">{{ $transaction->status }}</span>
                            @elseif($transaction->status === 'Gagal')
                                <span class="badge badge-danger">{{ $transaction->status }}</span>
                            @else
                                <span class="badge badge-warning">{{ $transaction->status }}</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Waktu</span>
                            <span class="text-sm font-medium text-gray-900">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3">
                            <span class="text-sm font-semibold text-gray-900">Total Bayar</span>
                            <span class="text-xl font-bold text-accent-500">Rp {{ number_format($transaction->amount) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('booking.history') }}" class="btn-gradient w-full text-center font-semibold py-3 rounded-xl text-white mt-6 inline-flex items-center justify-center gap-2 no-underline   hover:transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Riwayat
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- QR Code Modal --}}
    <div id="qr-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm" onclick="closeQrModal()">
        <div class="relative max-w-sm w-full mx-4 animate-fade-in" onclick="event.stopPropagation()">
            <button onclick="closeQrModal()" class="absolute -top-3 -right-3 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-500 hover:text-gray-900 cursor-pointer border-none z-10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-4 border-b border-gray-100 text-center">
                    <h4 class="font-bold text-gray-900" id="qr-modal-title">Scan QR Code</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Scan dengan aplikasi e-wallet Anda</p>
                </div>
                <div class="p-6 flex flex-col items-center">
                    {{-- QR Code generated via canvas --}}
                    <div id="qr-code-container" class="bg-white p-4 rounded-2xl border-2 border-gray-100 mb-4">
                        <canvas id="qr-canvas" width="200" height="200"></canvas>
                    </div>
                    <p class="text-sm text-gray-600 font-medium" id="qr-wallet-name"></p>
                    <p class="text-xs text-gray-400 mt-1">Nominal: <span class="font-semibold text-accent-500">Rp {{ number_format($transaction->amount) }}</span></p>
                    <div class="mt-4 w-full p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-xs text-gray-500">Setelah pembayaran, screenshot bukti dan upload di form samping</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview-image');
        const placeholder = document.getElementById('upload-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tersalin!';
            btn.classList.add('text-green-600');
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('text-green-600');
            }, 2000);
        });
    }

    // Payment method info
    const paymentInfo = {
        'Transfer Bank BCA': { type: 'bank', name: 'Bank BCA', number: '8720 5431 0098', holder: 'PT Pinto Air Indonesia' },
        'Transfer Bank Mandiri': { type: 'bank', name: 'Bank Mandiri', number: '1300 0215 7893', holder: 'PT Pinto Air Indonesia' },
        'Transfer Bank BRI': { type: 'bank', name: 'Bank BRI', number: '0341 0100 5678 901', holder: 'PT Pinto Air Indonesia' },
        'Transfer Bank BNI': { type: 'bank', name: 'Bank BNI', number: '0285 6720 4431', holder: 'PT Pinto Air Indonesia' },
        'GoPay': { type: 'ewallet', name: 'GoPay', color: '#22c55e' },
        'OVO': { type: 'ewallet', name: 'OVO', color: '#7c3aed' },
        'DANA': { type: 'ewallet', name: 'DANA', color: '#3b82f6' },
        'ShopeePay': { type: 'ewallet', name: 'ShopeePay', color: '#f97316' },
    };

    function updatePaymentInfo() {
        const select = document.getElementById('payment_method_select');
        const infoDiv = document.getElementById('selected-payment-info');
        const method = select.value;
        const info = paymentInfo[method];

        if (!info) { infoDiv.classList.add('hidden'); return; }

        infoDiv.classList.remove('hidden');

        if (info.type === 'bank') {
            infoDiv.innerHTML = `
                <div class="p-3 rounded-xl bg-blue-50 border border-blue-100">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <p class="text-xs font-semibold text-blue-700">${info.name}</p>
                    </div>
                    <p class="text-sm font-mono font-bold text-blue-800">${info.number}</p>
                    <p class="text-[10px] text-blue-600 mt-0.5">a.n. ${info.holder}</p>
                </div>
            `;
        } else {
            infoDiv.innerHTML = `
                <div class="p-3 rounded-xl border border-gray-100" style="background: ${info.color}10">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: ${info.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs font-semibold" style="color: ${info.color}">${info.name}</p>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1">Scan QR code pada bagian E-Wallet, lalu upload bukti pembayaran.</p>
                </div>
            `;
        }
    }

    // QR Code Generation
    const walletColors = {
        gopay: { primary: '#22c55e', secondary: '#16a34a' },
        shopeepay: { primary: '#f97316', secondary: '#ea580c' },
        ovo: { primary: '#7c3aed', secondary: '#6d28d9' },
        dana: { primary: '#3b82f6', secondary: '#2563eb' },
    };

    function generateQR(canvas, walletKey) {
        const ctx = canvas.getContext('2d');
        const size = 200;
        const moduleCount = 25;
        const moduleSize = Math.floor(size / moduleCount);
        const color = walletColors[walletKey];

        ctx.clearRect(0, 0, size, size);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, size, size);

        // Seed-based random for consistency per wallet
        let seed = 0;
        for (let i = 0; i < walletKey.length; i++) seed += walletKey.charCodeAt(i) * (i + 1);
        function seededRandom() {
            seed = (seed * 9301 + 49297) % 233280;
            return seed / 233280;
        }

        // Draw QR-like pattern
        const grid = [];
        for (let r = 0; r < moduleCount; r++) {
            grid[r] = [];
            for (let c = 0; c < moduleCount; c++) {
                grid[r][c] = false;
            }
        }

        // Finder patterns (top-left, top-right, bottom-left)
        function drawFinder(sr, sc) {
            for (let r = 0; r < 7; r++) {
                for (let c = 0; c < 7; c++) {
                    if (r === 0 || r === 6 || c === 0 || c === 6 || (r >= 2 && r <= 4 && c >= 2 && c <= 4)) {
                        grid[sr + r][sc + c] = true;
                    }
                }
            }
        }
        drawFinder(0, 0);
        drawFinder(0, moduleCount - 7);
        drawFinder(moduleCount - 7, 0);

        // Timing patterns
        for (let i = 8; i < moduleCount - 8; i++) {
            grid[6][i] = i % 2 === 0;
            grid[i][6] = i % 2 === 0;
        }

        // Data modules
        for (let r = 0; r < moduleCount; r++) {
            for (let c = 0; c < moduleCount; c++) {
                if (!grid[r][c] && seededRandom() > 0.5) {
                    // Skip finder and timing areas
                    const inFinder = (r < 8 && c < 8) || (r < 8 && c >= moduleCount - 8) || (r >= moduleCount - 8 && c < 8);
                    const inTiming = r === 6 || c === 6;
                    if (!inFinder && !inTiming) grid[r][c] = true;
                }
            }
        }

        // Render
        for (let r = 0; r < moduleCount; r++) {
            for (let c = 0; c < moduleCount; c++) {
                if (grid[r][c]) {
                    const inFinder = (r < 7 && c < 7) || (r < 7 && c >= moduleCount - 7) || (r >= moduleCount - 7 && c < 7);
                    ctx.fillStyle = inFinder ? color.secondary : color.primary;
                    const x = c * moduleSize;
                    const y = r * moduleSize;
                    const s = moduleSize - 1;
                    const radius = inFinder ? 0 : 1;
                    ctx.beginPath();
                    ctx.roundRect(x, y, s, s, radius);
                    ctx.fill();
                }
            }
        }

        // Center logo circle
        const center = size / 2;
        ctx.fillStyle = '#ffffff';
        ctx.beginPath();
        ctx.arc(center, center, 18, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = color.primary;
        ctx.beginPath();
        ctx.arc(center, center, 15, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 12px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        const labels = { gopay: 'G', shopeepay: 'S', ovo: 'O', dana: 'D' };
        ctx.fillText(labels[walletKey], center, center);
    }

    function showQrModal(name, walletKey) {
        const modal = document.getElementById('qr-modal');
        const title = document.getElementById('qr-modal-title');
        const walletName = document.getElementById('qr-wallet-name');
        const canvas = document.getElementById('qr-canvas');

        title.textContent = 'Scan QR ' + name;
        walletName.textContent = 'Pembayaran via ' + name;

        generateQR(canvas, walletKey);

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Auto-select the payment method
        const select = document.getElementById('payment_method_select');
        if (select) {
            select.value = name;
            updatePaymentInfo();
        }
    }

    function closeQrModal() {
        const modal = document.getElementById('qr-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeQrModal();
    });
</script>
@endsection
