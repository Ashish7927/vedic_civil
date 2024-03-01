<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Certificate\Entities\CertificateRecord;

class MyCertificatePageSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
     public $request;
     public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
      $certificate_records=CertificateRecord::with('course')->where('student_id',Auth::user()->id);
      if ($this->request->version) {
          $version = $this->request->version;
          if($version == 'free'){
              $certificate_records->whereHas('course', function ($query){
                  $query->where('price', 0)->where('discount_price', null);
              });
          }
          else{
              $certificate_records->whereHas('course', function ($query){
                  $query->where('price', '!=' ,0)->orWhere('discount_price', '!=' ,null);
              });
          }
      }
      $certificate_records=$certificate_records->latest()->paginate(5);

        return view(theme('components.my-certificate-page-section'), compact('certificate_records'));
    }
}
