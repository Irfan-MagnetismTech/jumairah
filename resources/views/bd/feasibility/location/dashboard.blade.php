
@extends('bd.feasibility.layout.app')
@section('title', 'Feasibility - Dashboard')

@section('content-grid', 'col-12')

@section('content')
<style>
        .table td, .table th {
    border-top: 1px !important;
        }
        .custom-color1 {
            background-color: #e5ebfd;
        }
        .bg_color1 {
            background-color: #F2DBDB;
        }
        .bg_color2 {
            background-color: #D6E3BC;
        }
    </style>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="3">
                <h4>{{ $bd_lead_location_name[0]->land_location }}</h4>
            </th>
        </tr>
        </thead>
    </table>
    <!-- <div class="container mt-5"> -->
        <table class="table table-sm text-white first_table mb-0" style="background-color: #205766;">
            <tbody>
                <tr>
                    <td class="text-right">Land address </td>
                    <td colspan="2">Zakir Hossain Road. CTG</td>
                    <td></td>
                    <td></td>
                    <!-- <td rowspan="3" class="">
                        <button type="menu" class="d-block addon_same_style1 float-right">BOQ</button>
                        <br />
                        <button type="menu" class="d-block addon_same_style1 float-right">Revenue</button><br/>
                        <button type="menu" class="d-block addon_same_style1 float-right">Finance</button>    
                    </td> -->
                    
                </tr>
                <tr>
                    <td class="text-right" class="text-right">Date</td>
                    <td  colspan="2">12-Dec-21</td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td class="text-right" class="text-right">Type of Land</td>
                    <td  colspan="2">Mixed Used
                        Commercial Cum
                    </td>
                    <td>Category : silver</td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td class="text-right" class="text-right">Special features</td>
                    <td  colspan="2">2FB+SB+ GF+ 13 Living Floors + Lounge</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right" class="text-right">Land Area in Khata</td>
                    <td>8.13</td>
                    <td class="text-right">RFPL Ratio</td>
                    <td>50.00 %</td>
                    <td class="text-right">BEP ( BDT / SFT )</td>
                    <td>9,367</td>
                </tr>
                <tr>
                    <td class="text-right">Average Construction Cost/sft</td>
                    <td>7505</td>
                    <td class="text-right">Avg Sales price/sft</td>
                    <td>10324</td>
                    <td class="text-right">Total Finance cost in crore</td>
                    <td>0.78</td>

                </tr>
                <tr>
                    <td class="text-right">Total Cost(BDT Crore)</td>
                    <td>21.1</td>
                    <td class="text-right">Revenue in Crore</td>
                    <td>24.3</td>
                    <td class="text-right">Net profit before tax in crore</td>
                    <td>3.2</td>
                    
                </tr>
                <tr>
                    <td class="text-right">ROI</td>
                    <td>15.2%</td>
                    <td class="text-right">Margin</td>
                    <td>13.16 %</td>
                    <td class="text-right">Finance cost (as % of Total Cash Outflow)</td>
                    <td>4 %</td>
                    
                </tr>
            </tbody>
        </table>
        <div class="row pt-0 mt-0">
            <div class="col-7 mr-0 pr-0">
                <table class="table table-bordered" style="border: 1.1px solid black;">
                    <tr class="text-center bg_color2" style="border: 1.1px solid black;">
                        <th colspan="4">Land Input</th>
                    </tr>
                    <tr>
                        <td colspan="2">Land Area in Record</td>
                        <td>FAR Index</td>
                        <td class="custom-color1 text-center">8.13</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Payment for Land (BDT Crore)</td>
                        <td></td>
                        <td class="custom-color1 text-center">1.13</td>
                    </tr>
                    <tr>
                        <td colspan="2">RFPL Ratio</td>
                        <td></td>
                        <td class="custom-color1 text-center">50.0%</td>
                    </tr>
                    <tr>
                        <td colspan="2">Registration Cost (%)</td>
                        <td></td>
                        <td class="custom-color1 text-center">0.00%</td>
                    </tr>
                    <tr>
                        <td colspan="2">Adjacent Road Width (Ft)</td>
                        <td>FAR Index</td>
                        <td class="custom-color1 text-center">80</td>
                    </tr>
                    <tr>
                        <td colspan="2">Type of Land</td>
                        <td></td>
                        <td class="custom-color1 text-center">Mixed Used</td>
                    </tr>
                    <tr>
                        <td colspan="2">FAR</td>
                        <td>FAR Index</td>
                        <td class="custom-color1 text-center">6.70</td>
                    </tr>
                    <tr>
                        <td colspan="2">MGC</td>
                        <td>FAR Index</td>
                        <td class="custom-color1 text-center">50.00%</td>
                    </tr>
                    <tr class="text-center bg_color2" style="border: 1.1px solid black;">
                        <th colspan="4">ADDITIONAL INPUTS</th>
                    </tr>
                    <tr>
                        <td colspan="2">Semi Basement + Basement</td>
                        <td></td>
                        <td class="custom-color1 text-center">3.00</td>
                    </tr>
                    <tr>
                        <td colspan="2">Parking area per car (SFT)</td>
                        <td></td>
                        <td class="custom-color1 text-center">350</td>
                    </tr>
                    <tr>
                        <td colspan="2">Building Front Length (FT)</td>
                        <td></td>
                        <td class="custom-color1 text-center">75</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Number of Floors :</td>
                        <td></td>
                        <td class="custom-color1 text-center">G + 13</td>
                    </tr>
                    <tr>
                        <td colspan="2">Fire Stair Area (SFT)</td>
                        <td></td>
                        <td class="custom-color1 text-center">150</td>
                    </tr>
                    <tr>
                        <td colspan="2">Number of Parkings in Basement</td>
                        <td></td>
                        <td class="custom-color1 text-center">25</td>
                    </tr>
                    <tr>
                        <td colspan="2">FAR Utilization in Ground Floor (% of MGC)</td>
                        <td>2927</td>
                        <td class="custom-color1 text-center">85%</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Construction Life Cycle (Years)</td>
                        <td></td>
                        <td class="custom-color1 text-center">3</td>
                    </tr>

                    <tr class="text-center bg_color2" style="border: 1.1px solid black;">
                        <th colspan="4">CONSTRUCTION COST (BDT /SFT)</th>
                    </tr>
                    <tr>
                        <td colspan="2">Service Pile Cost (Calculated &To be Used)</td>
                        <td>2746</td>
                        <td class="custom-color1 text-center">2746</td>
                    </tr>
                    <tr>
                        <td colspan="2">Construction Cost : Floor (Calculated &To Be Used)</td>
                        <td>2765</td>
                        <td class="custom-color1 text-center">2765</td>
                    </tr>
                    <tr>
                        <td colspan="2">Construction Cost : Basement (Calculated &To Be Used)</td>
                        <td>1450</td>
                        <td class="custom-color1 text-center">1450</td>
                    </tr>
                    <tr class="text-center bg_color2" style="border: 1.1px solid black;">
                        <th colspan="4">OTHER COST AND REVENUE INPUTSt</th>
                    </tr>
                    <tr>
                        <td colspan="2">Sales Revenue (BDT / SFT)</td>
                        <td>10324</td>
                        <td class="custom-color1 text-center">10,324</td>
                    </tr>
                    <tr>
                        <td colspan="2">Parking Sales Revenue (BDT / Parking)</td>
                        <td></td>
                        <td class="custom-color1 text-center">500,000</td>
                    </tr>
                    <tr>
                        <td colspan="2">Salary and Overhead per Month (BDT)</td>
                        <td></td>
                        <td class="custom-color1 text-center">316,203</td>
                    </tr>
                    
                   
                    
                    <tr>
                        <td colspan="2">Other Costs (Design, CDA, Speed money)</td>
                        <td></td>
                        <td class="custom-color1 text-center">11,497,688</td>
                    </tr>
                   
                    <tr class="text-center bg_color2" style="border: 1.1px solid black;">
                        <th colspan="4">TOTAL BUILTUP AREA (SFT)</th>
                    </tr>
                    <tr>
                        <td colspan="2">Semi Basement Floor Area (FAR Free)</td>
                        <td></td>
                        <td class="custom-color1 text-center">14,927</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Ground Floor Area (FAR Free)</td>
                        <td></td>
                        <td class="custom-color1 text-center">2,476</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Buildup Area as per FAR (SFT)</td>
                        <td></td>
                        <td class="custom-color1 text-center">39,219</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Bonus Sale-able Area</td>
                        <td>3890</td>
                        <td class="custom-color1 text-center">5883</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Fire Stair Area (SFT)</td>
                        <td></td>
                        <td class="custom-color1 text-center">1590</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Additional Area for Front Balcony</td>
                        <td></td>
                        <td class="custom-color1 text-center">960</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Additional Area for Other Balcony</td>
                        <td></td>
                        <td class="custom-color1 text-center">980</td>
                    </tr>
                    <tr style="border: 1.1px solid black;" class="bg_color2">
                        <th colspan="3">Total Buildup Area</th>
                        <!-- <td></td> -->
                        <th class="custom-color1 text-center">62,504</th>
                    </tr>
                </table>
            </div>
            <div class="col-5 ml-0 pl-0">
                <table class="table table-bordered" style="border: 1.1px solid black; border-left: 0px;">
                    <tr class="text-center bg_color1" style="border: 1.1px solid black;border-left: 0px;">
                        <th colspan="3">RESULT SUMMARY</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Builtup Area (SFT)</td>
                        <td class="custom-color1">62,504</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">TTotal Sale-able Area of RFPL (SFT)</td>
                        <td class="custom-color1">22,551</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Sales Revenue (BDT Crore)</td>
                        <td class="custom-color1">24.3</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Cost (BDT Crore)</td>
                        <td class="custom-color1">21.1</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Net Profit Before Tax (BDT Crore)</th>
                        <th class="custom-color1">3.2</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Margin</td>
                        
                        <td class="custom-color1">13.2%</td>
                    </tr>
                   
                    <tr>
                        <td colspan="2" class="text-right">ROI</td>
                        <td class="custom-color1">15.2%</td>
                    </tr>
                    <tr class="bg_color1" style="border: 1.1px solid black;border-left: 0px;">
                        <th colspan="2" class="text-right">BEP (BDT / SFT)</th>
                        <th class="custom-color1">9367</th>
                    </tr>
                    <!-- <tr>
                        <th colspan="2" class="text-right addon_same_style2"></th>
                        <th></th>
                    </tr> -->
                    <tr class="text-center bg_color1" style="border: 1.1px solid black;border-left: 0px;">
                        <th colspan="3">CALCULATED INFORMATION</th>
                    </tr>
                   
                    <tr>
                        <td colspan="2" class="text-right">Maximum Ground Coverage (SFT)</td>
                        <td class="custom-color1">2,927</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Minimum Number of Floors Considering MGC</td>
                        <td class="custom-color1">G + 13</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Floors Used</td>
                        <td class="custom-color1">G + 13</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Typical Floor Area WITH Bonus FAR</td>
                        <td class="custom-color1">3,277</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Total Number of Parking</th>
                        <th class="custom-color1">25</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Land Payment Per Katha (BDT Lac)</td>
                        
                        <td class="custom-color1">13.88</td>
                    </tr>
                   
                    <tr>
                        <td colspan="2" class="text-right">Avg Construction Cost (BDT/ SFT Builtup Area)</td>
                        <td class="custom-color1">2,708</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Avg Construction Cost (BDT/ SFT Sale-able Area)</td>
                        <td class="custom-color1">7,505</td>
                    </tr>
                    <!-- <tr>
                        <th colspan="2" class="text-right addon_same_style2"></th>
                        <th></th>
                    </tr> -->
                    </tr> <tr class="text-center bg_color1" style="border: 1.1px solid black;border-left: 0px;">
                        <th colspan="3">COSTS SUMMARY (BDT CRORE)</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Payment for Land</td>
                        <td class="custom-color1">1.13</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Registration Cost</td>
                        <td class="custom-color1">--</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Construction Cost</td>
                        <td class="custom-color1">16.93</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Overhead</td>
                        <td class="custom-color1">1.14</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Other Costs</th>
                        <th class="custom-color1">1.15</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Cost before Finance Cost</td>
                        
                        <td class="custom-color1">20.34</td>
                    </tr>
                   
                    <tr>
                        <td colspan="2" class="text-right">Finance Cost</td>
                        <td class="custom-color1">0.78</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Finance cost (as % of Total Cash Outflow)</th>
                        <th class="custom-color1">4 %</th>
                    </tr> 
                    <tr>
                        <th colspan="2" class="text-right">Total Cost</th>
                        <th class="custom-color1">21.12</th>
                    </tr>
                    <!-- <tr>
                        <th colspan="2" class="text-right addon_same_style2"></th>
                        <th></th>
                    </tr> -->
                    <tr class="text-center bg_color1" style="border: 1.1px solid black;border-left: 0px;">
                        <th colspan="3" class="addon_same_style2">REVENUE SUMMARY (BDT CRORE)</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right addon_same_style2">Total Sales Revenue from FAR Area</td>
                        <td class="custom-color1">20.24</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Sales Revenue from Bonus FAR Area</td>
                        <td class="custom-color1">3.04</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Sales Revenue from Bonus FAR Area</td>
                        <td class="custom-color1">3.04</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Sales Revenue from Bonus FAR Area</td>
                        <td class="custom-color1">3.04</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total Sales Revenue from Bonus FAR Area</td>
                        <td class="custom-color1">3.04</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Sales Revenue from Parking & Utility</td>
                        <td class="custom-color1">1.05</td>
                    </tr>
                    <tr style="border: 1.1px solid black;border-left: 0px;">
                        <th colspan="2" class="text-right">Total Sales Revenue</th>
                        <th class="custom-color1">24.33</th>
                    </tr>
                </table>
            </div>
        </div>
    <!-- </div> -->
@endsection
