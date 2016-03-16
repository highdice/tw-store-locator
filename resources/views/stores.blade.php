@extends('layouts.app')

@section('content')
<center>
<div id="search-container">
    <i class="glyphicon glyphicon-search"></i>
    <input type="text" id="search-input" class="form-control search-input" placeholder="Search Here . . ." />
    <button id="search-button" class="btn btn-primary search-button">GO</button>
</div>
</center>
<aside>
    <div id="sidebar">
        <ul>
            <li id="test"><i class="glyphicon glyphicon-search"></i></li>
            <li id="test2"><i class="glyphicon glyphicon-home"></i></li>
            <li><i class="glyphicon glyphicon-cog"></i></li>
        </ul>
    </div>

    <div id="sidebar-content-container">
        <div class="title">Advanced Search</div>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Island Group
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <ul>
                    <li>
                        <input type="checkbox" id="island-group-all" name="island_group" value="all"><label for="island-group-all">All</label>
                    </li>
                    <li>
                        <input type="checkbox" id="luzon" name="island_group" value="luzon"><label for="luzon">Luzon</label>
                    </li>
                    <li>
                        <input type="checkbox" id="visayas" name="island_group" value="visayas"><label for="visayas">Visayas</label>
                    </li>
                    <li>
                        <input type="checkbox" id="mindanao" name="island_group" value="mindanao"><label for="mindanao">Mindanao</label>   
                    </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Region
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                <ul>
                    <li>
                        <input type="checkbox" id="region-all" name="region" value="all"><label for="region-all">All</label>
                    </li>
                    <li>
                        <input type="checkbox" id="ncr" name="region" value="ncr"><label for="ncr">National Capital Region</label>
                    </li>
                    <li>
                        <input type="checkbox" id="ilocos" name="region" value="ilocos"><label for="ilocos">Ilocos</label>
                    </li>
                    <li>
                        <input type="checkbox" id="car" name="region" value="car"><label for="car">CAR</label>   
                    </li>
                    <li>
                        <input type="checkbox" id="cagayan-valley" name="region" value="cagayan_valley"><label for="cagayan-valley">Cagayan Valley</label>   
                    </li>
                    <li>
                        <input type="checkbox" id="central-luzon" name="region" value="central_luzon"><label for="central-luzon">Central Luzon</label>   
                    </li>
                </ul>
                </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Category
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <ul>
                    <li>
                        <input type="checkbox" id="category-all" name="island_group" value="all"><label for="category-all">All</label>
                    </li>
                    <li>
                        <input type="checkbox" id="branch" name="island_group" value="branch"><label for="branch">Branch</label>
                    </li>
                    <li>
                        <input type="checkbox" id="saatellite" name="island_group" value="satellite"><label for="satellite">Satellite</label>   
                    </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary login-button">
                    GO
                </button>
            </div>
        </div>
    </div>
</aside>
<div id="map"></div>
<div id='loader'>
    <div class="circles-loader"></div>
</div>
@endsection