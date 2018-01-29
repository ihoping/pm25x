@extends('layouts.main')
@section('title', '资讯')
@section('content')
    <div class="row news-desc">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3>忘记从什么时候开始，用颜色表示空气</h3>
            <h3>不知道什么时候可以，用甜度描述空气</h3>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row news-content">
        <div class="col-md-12">
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item" style="border-bottom: 1px solid #ddd">Cras justo odio</li>
                    <li class="list-group-item" style="border-bottom: 1px solid #ddd">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>

                </ul>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            </div>
    </div>
@endsection
@section('script')
@endsection