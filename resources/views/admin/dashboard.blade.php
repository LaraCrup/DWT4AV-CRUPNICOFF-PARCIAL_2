@extends('layouts.admin')

@section('pageTitle', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="/styles/dashboardStyles.css">
@endpush

@section('content')
    <section>
        <h1 class="fontTitle">Dashboard</h1>
        <div class="dashboardContainer fontBody parent">
            <div class="dashboardCard div1">
                <h2 class="fontTitle">Ventas totales por día</h2>
                <div>
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="statsInfo fontBody">
                    <div class="statItem">
                        <span class="statLabel">Ventas de hoy:</span>
                        <span class="statValue">{{ $salesTodayAmount ?? '$15,240' }}</span>
                    </div>
                    <div class="statItem">
                        <span class="statLabel">Promedio semanal:</span>
                        <span class="statValue">{{ $salesWeeklyAverage ?? '$12,450' }}</span>
                    </div>
                </div>
            </div>

            <div class="dashboardCard div2">
                <h2 class="fontTitle">Usuarios con mayores compras</h2>
                <ul class="topUsersList fontBody">
                    @forelse($topUsers ?? [] as $user)
                        <li class="topUser{{ $loop->index >= 5 ? ' desktop-only' : '' }}">
                            <img src="/storage/shared/profile.png" alt="Imágen de Perfil" class="userAvatar">
                            <div class="userData">
                                <p class="userName{{ $loop->index >= 5 ? ' fontBody' : '' }}">{{ $user['name'] }}</p>
                                <p class="userSpent">{{ $user['amount'] }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="topUser">
                            <p>No hay datos disponibles</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="dashboardCard div3">
                <h2 class="fontTitle">Productos más vendidos</h2>
                <ul class="productRankingList fontBody">
                    @forelse($topProducts ?? [] as $product)
                        <li class="productItem">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                            <div>
                                <span class="productName">{{ $product['name'] }}</span>
                                <span class="productSales">{{ $product['sales'] ?? '0 unidades' }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="productItem">
                            <p>No hay datos disponibles</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="dashboardCard div4">
                <h2 class="fontTitle">Resumen mensual</h2>
                <div class="summaryItem">
                    <div class="summaryIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                            <path fill="#9381ff"
                                d="M5.925 21q-.575 0-1.112-.4t-.713-.975q-.625-2.1-1.025-3.637t-.638-2.7t-.337-2.063T2 9.5q0-2.3 1.6-3.9T7.5 4h5q.675-.9 1.713-1.45T16.5 2q.625 0 1.063.438T18 3.5q0 .15-.038.3t-.087.275q-.1.275-.187.55t-.138.6L19.825 7.5H21q.425 0 .713.288T22 8.5v5.25q0 .325-.187.575t-.513.375l-2.125.7l-1.25 4.175q-.2.65-.725 1.038T16 21h-2q-.825 0-1.412-.587T12 19h-2q0 .825-.587 1.413T8 21zM6 19h2v-2h6v2h2l1.55-5.15l2.45-.825V9.5h-1L15.5 6q0-.5.063-.975t.187-.925q-.725.2-1.275.688T13.675 6H7.5Q6.05 6 5.025 7.025T4 9.5q0 1.025.525 3.513T6 19m10-8q.425 0 .713-.288T17 10t-.288-.712T16 9t-.712.288T15 10t.288.713T16 11m-4-2q.425 0 .713-.288T13 8t-.288-.712T12 7H9q-.425 0-.712.288T8 8t.288.713T9 9zm0 2.55" />
                        </svg>
                    </div>
                    <div class="summaryData">
                        <span class="summaryLabel">Ingresos</span>
                        <span class="summaryValue">{{ $monthlyRevenue ?? '$87,540' }}</span>
                    </div>
                </div>
                <div class="summaryItem">
                    <div class="summaryIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                            <path fill="#9381ff"
                                d="M7 22q-.825 0-1.412-.587T5 20t.588-1.412T7 18t1.413.588T9 20t-.587 1.413T7 22m10 0q-.825 0-1.412-.587T15 20t.588-1.412T17 18t1.413.588T19 20t-.587 1.413T17 22M6.15 6l2.4 5h7l2.75-5zM5.2 4h14.75q.575 0 .875.513t.025 1.037l-3.55 6.4q-.275.5-.737.775T15.55 13H8.1L7 15h11q.425 0 .713.288T19 16t-.288.713T18 17H7q-1.125 0-1.7-.987t-.05-1.963L6.6 11.6L3 4H2q-.425 0-.712-.288T1 3t.288-.712T2 2h1.625q.275 0 .525.15t.375.425zm3.35 7h7z" />
                        </svg>
                    </div>
                    <div class="summaryData">
                        <span class="summaryLabel">Pedidos</span>
                        <span class="summaryValue">{{ $monthlyOrders ?? '423' }}</span>
                    </div>
                </div>
                <div class="summaryItem">
                    <div class="summaryIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                            <path fill="#9381ff"
                                d="M12 12q-1.65 0-2.825-1.175T8 8t1.175-2.825T12 4t2.825 1.175T16 8t-1.175 2.825T12 12m-8 6v-.8q0-.85.438-1.562T5.6 14.55q1.55-.775 3.15-1.162T12 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2v.8q0 .825-.587 1.413T18 20H6q-.825 0-1.412-.587T4 18m2 0h12v-.8q0-.275-.137-.5t-.363-.35q-1.35-.675-2.725-1.012T12 15t-2.775.338T6.5 16.35q-.225.125-.363.35T6 17.2zm6-8q.825 0 1.413-.587T14 8t-.587-1.412T12 6t-1.412.588T10 8t.588 1.413T12 10m0 8" />
                        </svg>
                    </div>
                    <div class="summaryData">
                        <span class="summaryLabel">Nuevos Clientes</span>
                        <span class="summaryValue">{{ $newCustomers ?? '89' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        window.dailySalesData = {!! $dailySalesJson ?? '[]' !!};
    </script>
    <script src="/scripts/canvas.js"></script>
@endsection
