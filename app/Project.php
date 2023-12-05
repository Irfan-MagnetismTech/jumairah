<?php

namespace App;

use App\Accounts\Account;
use App\Accounts\BalanceAndIncomeLine;
use App\Boq\BoqArea;
use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Departments\Civil\BoqReinforcementSheet;
use App\Boq\Departments\Civil\Cost\BoqCivilConsumableBudget;
use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Boq\Departments\Eme\BoqEmeBudget;
use App\Boq\Departments\Eme\BoqEmeCalculation;
use App\Boq\Departments\Sanitary\ProjectWiseLaborCost;
use App\Boq\Departments\Sanitary\SanitaryAllocation;
use App\Boq\Departments\Sanitary\SanitaryBudgetSummary;
use App\Boq\Department\Civil\Cost\BoqConsumableCost;
use App\Boq\Projects\BoqFloorProject;
use App\CostCenter;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\PoReportProjectWise;
use App\Procurement\Requisitiondetails;
use App\Sells\Apartment;
use App\Sells\CollectionYearlyBudget;
use App\Sells\SalesYearlyBudget;
use App\Sells\Sell;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model {
    use HasFactory;
    use LogsActivity;
    /**
     * @var mixed
     */
    protected static $logOnlyDirty = true;
    /**
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'shortName', 'location', 'category', 'storied', 'res_storied_from', 'res_storied_to', 'com_storied_from',
        'com_storied_to', 'signing_date', 'cda_approval_date', 'innogration_date', 'handover_date', 'project_cost', 'landsize', 'buildup_area',
        'sellable_area', 'units', 'parking', 'landowner_share', 'developer_share', 'landowner_cash_benefit', 'agreement', 'floor_plan',
        'others', 'developer_unit', 'landowner_unit', 'developer_parking', 'landowner_parking', 'basement', 'types', 'lO_sellable_area',
        'developer_sellable_area', 'lift', 'generator', 'features', 'rebate_charge', 'delay_charge', 'rental_compensation', 'photo', 'nid',
        'tin', 'doa', 'poa', 'khajna_receipt', 'khatiyan', 'warishion_certificate', 'luc', 'cda', 'nec', 'electricity_bill', 'wasa_billl', 'holding_tex', 'gas_bill'];

    /**
     * @return mixed
     */
    public function projectType() {
        return $this->hasMany( ProjectType::class );
    }

    public function accounts() {
        return $this->morphMany( Account::class, 'accountable' );
    }

    public function collectionYearlyBudget() {
        return $this->hasMany( CollectionYearlyBudget::class );
    }

    public function salesYearlyBudget() {
        return $this->hasMany( SalesYearlyBudget::class );
    }

    public function sanitaryBudgetSummary() {
        return $this->hasOne( SanitaryBudgetSummary::class )->where( 'type', 0 );
    }

    public function sanitaryBudgetSummaryIncremental() {
        return $this->hasMany( SanitaryBudgetSummary::class, 'project_id' )->where( 'type', 1 );
    }

    public function BoqEmeBudget() {
        return $this->hasMany( BoqEmeBudget::class );
    }

    public function projectWiseLAborCost() {
        return $this->hasMany( ProjectWiseLaborCost::class );
    }

    public function SanitaryAllocation() {
        return $this->hasMany( SanitaryAllocation::class )->where( 'type', 'Residential' );
    }
    public function SanitaryAllocationCommertial() {
        return $this->hasMany( SanitaryAllocation::class )->where( 'type', 'Commercial' );
    }

    /**
     * @return mixed
     */
    public function apartments() {
        return $this->hasMany( Apartment::class );
    }

    /**
     * @return mixed
     */
    public function costCenter() {
        return $this->hasOne( CostCenter::class );
    }
    public function balanceIncomeLine() {
        return $this->hasOne( BalanceAndIncomeLine::class, 'project_id' );
    }

    public function ledgers() {
        return $this->hasManyThrough( LedgerEntry::class, Account::class, 'accountable_id', 'account_id' )
            ->where( 'accountable_type', Project::class );
    }

    /**
     * @return mixed
     */
    public function unsoldApartments() {
        return $this->hasMany( Apartment::class, 'project_id' )
            ->where( 'owner', 1 )
            ->whereDoesntHave( 'sell' );
    }

    /**
     * @return mixed
     */
    public function sells() {
        return $this->hasManyThrough( Sell::class, Apartment::class );
    }

    /**
     * @return mixed
     */
    public function parkings() {
        return $this->hasMany( Parking::class, 'project_id' );
    }

    /**
     * @param $input
     */
    public function setSigningDateAttribute( $input ) {
        $this->attributes['signing_date'] = !empty( $input ) ? Carbon::createFromFormat( 'd-m-Y', $input )->format( 'Y-m-d' ) : null;

    }

    /**
     * @param $input
     * @return mixed
     */
    public function getSigningDateAttribute( $input ) {
        $signing_date = !empty( $input ) ? Carbon::createFromFormat( 'Y-m-d', $input )->format( 'd-m-Y' ) : null;

        return $signing_date;
    }

    /**
     * @param $input
     */
    public function setCdaApprovalDateAttribute( $input ) {
        $this->attributes['cda_approval_date'] = !empty( $input ) ? Carbon::createFromFormat( 'd-m-Y', $input )->format( 'Y-m-d' ) : null;

    }

    /**
     * @param $input
     * @return mixed
     */
    public function getCdaApprovalDateAttribute( $input ) {
        $cda_approval_date = !empty( $input ) ? Carbon::createFromFormat( 'Y-m-d', $input )->format( 'd-m-Y' ) : null;

        return $cda_approval_date;
    }

    /**
     * @param $input
     */
    public function setInnogrationDateAttribute( $input ) {
        $this->attributes['innogration_date'] = !empty( $input ) ? Carbon::createFromFormat( 'd-m-Y', $input )->format( 'Y-m-d' ) : null;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function getInnogrationDateAttribute( $input ) {
        $innogration_date = !empty( $input ) ? Carbon::createFromFormat( 'Y-m-d', $input )->format( 'd-m-Y' ) : null;

        return $innogration_date;
    }

    /**
     * @param $input
     */
    public function setHandoverDateAttribute( $input ) {
        $this->attributes['handover_date'] = !empty( $input ) ? Carbon::createFromFormat( 'd-m-Y', $input )->format( 'Y-m-d' ) : null;

    }

    /**
     * @param $input
     * @return mixed
     */
    public function getHandoverDateAttribute( $input ) {
        $handover_date = !empty( $input ) ? Carbon::createFromFormat( 'Y-m-d', $input )->format( 'd-m-Y' ) : null;

        return $handover_date;
    }

    /**
     * @return mixed
     */
    public function getRebateChargePerDayAttribute() {
        return $this->rebate_charge / 360;
    }

    /**
     * @return mixed
     */
    public function getDelayChargePerDayAttribute() {
        return $this->delay_charge / 30;
    }

//    public function getProjectValueAttribute()
//    {
//        return $this->apartments()->sum('total_value');
//    }

    /**
     * @return mixed
     */
    public function getStatusAttribute() {
        $status = null;
        if ( $this->handover_date ) {
            $status = 'Ready';
        } else if ( $this->innogration_date ) {
            $status = 'Ongoing';
        } else {
            $status = 'Upcoming';
        }

        return $status;
    }

    /**
     * @return mixed
     */
    public function PoReportProjectWise() {
        return $this->hasOne( PoReportProjectWise::class, 'project_id', 'id' )->withDefault();
    }

    /**
     * Get the boq area-floors which are owned by the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boqAreas(): HasMany {
        return $this->hasMany( BoqArea::class, 'project_id', 'id' );
    }

    /**
     * @return mixed
     */
    public function boqConsumableCosts(): HasMany {
        return $this->hasMany( BoqConsumableCost::class, 'project_id', 'id' );
    }

    /**
     * Get the projects that are not already used in boq area-floors.
     *
     * @return mixed
     */
    public function scopeInBoqAreas( $query, $area_type ) {
        $distinct_projects = BoqArea::distinct()
            ->where( 'area_type', $area_type )
            ->pluck( 'project_id' );

        return $query->whereIn( 'id', $distinct_projects );
    }

    /**
     * Get the projects that are not already used in boq area-floors.
     *
     * @return mixed
     */
    public function scopeNotInBoqAreas( $query ) {
        $boq_area_floors = BoqArea::distinct()->pluck( 'project_id' );

        return $query->whereNotIn( 'id', $boq_area_floors );
    }

    /**
     * @return mixed
     */
    public function boqFloorProjects(): HasMany {
        return $this->hasMany( BoqFloorProject::class, 'project_id', 'id' );
    }

    /**
     * @return mixed
     */
    public function boqCivilBudgets(): HasMany {
        return $this->hasMany( BoqCivilBudget::class, 'project_id' );
    }

    public function boqReinforcementBudgets(): HasMany {
        return $this->hasMany( BoqReinforcementSheet::class, 'project_id' );
    }

    public function boqSupremeBudgets(): HasMany {
        return $this->hasMany( BoqSupremeBudget::class, 'project_id' );
    }

    public function boqRevisedBudgets(): HasMany {
        return $this->hasMany( BoqCivilRevisedSheet::class, 'project_id' );
    }

    public function requisitionDetails(): HasMany {
        return $this->hasMany( Requisitiondetails::class, 'project_id' );
    }

    /**
     * @return mixed
     */
    public function boqCivilConsumableCosts(): HasMany {
        return $this->hasMany( BoqCivilConsumableBudget::class, 'project_id', 'id' );
    }

    /**
     * @return mixed
     */
    public function boqCivilOtherCost(): HasMany {
        return $this->hasMany( BoqCivilBudget::class, 'project_id', 'id' );
    }

    public function boqEmeCalculation(): HasMany {
        return $this->hasMany( BoqEmeCalculation::class, 'project_id' );
    }

}
