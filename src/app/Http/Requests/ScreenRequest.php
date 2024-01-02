<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

class ScreenRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'screening_date' => ['required', 'date', 'after:today'],
      'start_time_hour' => ['required', 'integer', 'between:0,23'],
      'start_time_minute' => ['required', 'integer', 'between:0,59'],
      'end_time_hour' => ['required', 'integer', 'between:0,23'],
      'end_time_minute' => ['required', 'integer', 'between:0,59'],
    ];
  }

  public function after(): array
  {

    $start_time = Carbon::createFromTime($this->start_time_hour, $this->start_time_minute, 0);
    $start_time = $start_time->format('H:i:s');

    $end_time = Carbon::createFromTime($this->end_time_hour, $this->end_time_minute, 0);
    $end_time = $end_time->format('H:i:s');

    $this->merge([
      'start_time' => $start_time,
      'end_time' => $end_time,
    ]);

    return [
      function (Validator $validator) use ($start_time, $end_time) {

        // $start_timeが$end_timeよりも後の時間の場合はエラー
        if ($start_time > $end_time) {
          $validator->errors()->add('start_end_time', '開始時間は終了時間よりも前に設定してください。');
        }
      }
    ];
  }
}
