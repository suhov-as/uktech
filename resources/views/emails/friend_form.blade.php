@extends('emails.layouts.default')

@php($url = [
  'catalog_new_building'         => 'invest-in-a-new-building',
  'catalog_development_projects' => 'invest-in-development-projects',
  'catalog_buy'                  => 'buy',
  'catalog_rent'                 => 'rent',
])

@section('content')
  <tr>
    <td align="center" style="padding-top: 35px;">
      <table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
        <tbody>
        <tr>
          <td
            style="color:#000000;  font-family:Verdana, Arial, sans-serif; font-size:15px; line-height: 21px;">
            @php($n = (!empty($your_name) || !empty($your_surname))
              ? $your_name . ' ' . $your_surname
              : "<a style=\"color: #332243\">$email</a>")
            {!! str_replace('&&', $n, $langSt($params['friends_form_text']['key'])) !!}
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>

  @if(!empty($comment_text))
    <tr>
      <td align="center" style="padding-top: 23px;">
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
          <tbody>
          <tr>
            <td valign="top" style="height: 21px; font-size: 21px; line-height: 21px;">
              <img width="26" height="21" title="''" alt="''" src="{{ env('APP_URL') }}/images/quotes.png" style="border:none; max-width: 26px; height: auto; max-height: 21px;">
            </td>

            <td style="font-size: 15px; line-height: 20px; font-style: italic; padding-left: 30px; font-family:Verdana, Arial, sans-serif; color:#332243; text-align: left;">
              {{ empty($comment_text) ? '-' : $comment_text }}
            </td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
  @endif

  @if(!empty($message_s))
    <tr>
      <td align="center" style="padding-top: 23px;">
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
          <tbody>
          <tr>
            <td valign="top" style="height: 21px; font-size: 21px; line-height: 21px;">
              <img width="26" height="21" title="''" alt="''"
                src="{{ env('APP_URL') }}/images/quotes.png"
                style="border:none; max-width: 26px; height: auto; max-height: 21px;">
            </td>

            <td
              style="font-size: 15px; line-height: 20px; font-style: italic; padding-left: 30px; font-family:Verdana, Arial, sans-serif; color:#F9690E; text-align: left;">
              {{ empty($comment_text) ? '-' : $comment_text }}
            </td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
  @endif

  <tr>
    <td>
      @foreach($objects as $val)
        <table width="260px" cellspacing="0" cellpadding="0"
          style="height: 230px;margin-top: 25px;margin-left: 15px; float: left; text-align: left;">
          <tbody>
          <tr>
            <td align="center" style="height: 128px; font-size: 128px; line-height: 128px;">
              <a
                href="{{ env('APP_URL') }}/catalog/{{ $name_url ?? $url[$val['name_table']] }}/{{ $val['translation'] ?? $val['id'] }}"
                style="color: #909192; text-decoration: none;" target="_blank">

                @php($path_small = env('APP_URL') . '/images/files/small/')
                @php($img_small = $val['file'] ? $val['crop'] ? $path_small . $val['crop'] : $path_small . $val['file'] : '')

                <img
                  width="260"
                  height="128"
                  title="{{ $langSt($val['name']) }}"
                  alt="{{ $langSt($val['name']) }}"
                  src="{{ $img_small }}"
                  style="font-size:25px; border:none; max-width: 260px; height: auto; max-height: 128px;"
                />
              </a>
            </td>
          </tr>
          <tr>
            <td >
              <table width="100%" cellspacing="0" cellpadding="0" style="text-align: left;">
                <tbody>
                <tr>
                  <td align="left" colspan="2" style="text-align: left;">
                    <a
                      href="{{ env('APP_URL') }}/catalog/{{ $name_url ?? $url[$val['name_table']] }}/{{ $val['translation'] ?? $val['id'] }}"
                      style="text-decoration: none; text-transform: uppercase; color: #000000; font-size: 17px; line-height: 20px; font-family: Verdana, Arial, sans-serif;"
                    >
                      <strong>{{ $langSt($val['name']) }}</strong>
                    </a>
                  </td>
                </tr>

                <tr>
                  <td align="left"
                    style="text-align: left; color: #000000; font-size: 12px; line-height: 20px; font-family: Verdana, Arial, sans-serif; min-height: 20px; min-width: 160px;">
                      @if( !$val['do_not_show_area'])
                    @if(((int) $val['area_from']) > 0 || ((int) $val['area_to']) > 0 || ((int) $val['area']) > 0)
                      @if($lang == 'ru')
                        @if($val['area_to'] ?? false)
                          @if($val['area_to'])
                            @if($val['area_to'])
                              S =  {{ $val['area_to'] }}
                            @endif
                          @else
                            S = {{ $val['area_from'] }}
                            @if($val['area_to'])
                              - {{ $val['area_to'] }}
                            @endif
                          @endif

                          @lang('main.ft_2')
                        @else
                          S = {{ $val['area'] }} @lang('main.ft_2')
                        @endif
                      @else
                        @if($val['area_to'] ?? false)
                          @if($val['area_to'] && !$val['area_from'])
                            @if($val['area_to'])
                              S =  {{ round($val['area_to'] * 10.7638673611111) }}
                            @endif
                          @else
                            S = {{ round($val['area_from'] * 10.7638673611111) }}
                            @if($val['area_to'])
                              - {{ round($val['area_to'] * 10.7638673611111) }}
                            @endif
                          @endif

                          @lang('main.ft_2')
                        @else
                          S = {{ round($val['area'] * 10.7638673611111) }} @lang('main.ft_2')
                        @endif
                      @endif
                    @endif
                      @endif
                  </td>
                  <td align="left"
                    style="text-align: left; font-style: italic; color: #000000; font-size: 12px; line-height: 10px; font-family: Verdana, Arial, sans-serif;">
                      @if( !$val['do_not_show_bedrooms'])
                    @if($val['bedrooms_from'] || $val['bedrooms'])
                        @if($val['bedrooms_from'] ?? false)
                          {{ $val['bedrooms_from'] }} @if($val['bedrooms_to']) - {{ $val['bedrooms_to'] }}@endif
                        @else
                          {{ $val['bedrooms'] }}
                        @endif
                          @lang('main.bedrooms')
                    @endif

                    @if(!$val['bedrooms_from'] && $val['bedrooms_to'])
                      {{ $val['bedrooms_to'] }}
                      @lang('main.bedrooms')
                    @endif
                          @endif
                  </td>
                </tr>

                <tr>
                  <td colspan="2" align="left"
                    style="text-align: left; font-style: italic; color: #000000; font-size: 14px; line-height: 10px; font-family: Verdana, Arial, sans-serif;">
                    @if( !$val['do_not_show_price'])
                        @if(((int) $val['price_money_from']) > 0 || ((int) $val['price_money_to']) > 0 || ((int) $val['price_money']) > 0)
                          <span class="price">
                            @if($val['price_money_from'] ?? false)
                              £{{ number_format($val['price_money_from'], 0, ',', ',') }}
                              @if(((int) $val['price_money_to']) > 0) - £{{ number_format($val['price_money_to'], 0, ',', ',') }}@endif
                            @else
                              @if(((int) $val['price_money']) > 0)
                                £{{ number_format($val['price_money'], 0, ',', ',') }}
                              @endif

                                @if(((int) $val['price_money_to']) > 0)
                                  £{{ number_format($val['price_money_to'], 0, ',', ',') }}
                                @endif
                            @endif
                          </span>
                        @endif
                      @else
                          <span class="price">TBC</span>
                    @endif
                  </td>
                </tr>
                </tbody>
              </table>
            </td>
          </tr>
          </tbody>
        </table>
      @endforeach
    </td>
  </tr>

  @if($is_agent_form)
    <tr>
      <td align="center" style="padding-top: 36px;">
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
          <tbody>
          <tr>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              @lang('main.first_name'):
            </td>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              {{ empty($your_name) ? '-' : $your_name }}
            </td>
          </tr>

          <tr>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              @lang('main.second_name'):
            </td>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              {{ empty($your_surname) ? '-' : $your_surname }}
            </td>
          </tr>

          <tr>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              @lang('main.phone_number'):
            </td>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              {{ empty($phone) ? '-' : $phone }}
            </td>
          </tr>

          <tr>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              @lang('main.email'):
            </td>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              {!! empty($email) ? '-' : "<a style=\"color: #332243\">$email</a>" !!}
            </td>
          </tr>

          <tr>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#657482; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              @lang('main.emails_friends'):
            </td>
            <td width="50%"
              style="font-size: 15px; line-height: 18px; padding: 10px 0; font-family:Verdana, Arial, sans-serif; color:#30343f; text-align: left; border-top-width: 1px; border-top-color: #dcbaa1; border-top-style: dashed;">
              {{ join(',' , $friend_email) }}
            </td>
          </tr>

          <tr>
            <td width="50%" style="border-bottom-width: 1px; border-bottom-color: #dcbaa1; border-bottom-style: dashed;"></td>
            <td width="50%" style="border-bottom-width: 1px; border-bottom-color: #dcbaa1; border-bottom-style: dashed;"></td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
  @endif
@endsection
