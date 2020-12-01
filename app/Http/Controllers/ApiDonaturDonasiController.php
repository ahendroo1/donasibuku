<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Mail;
use Hash;
use Cache;
use Validator;

class ApiDonaturDonasiController extends \crocodicstudio\crudbooster\controllers\ApiController {

    function __construct() {    
        $this->table     = "donasi";        
        $this->permalink = "donatur_donasi";    
        $this->method_type = "post";    
    }


    public function hook_before(&$postdata) {
        //Code here if you want execute some action before API Query Called
        
        $id_donatur  = $postdata['id_donatur'];
        $nama        = $postdata['nama'];
        $tlpn        = $postdata['tlpn'];
        $email       = $postdata['email'];
        $id_bank     = $postdata['id_bank'];
        $donasi_item = $postdata['donasi_item'];

        $row_bank = DB::table('bank')->where('id',$id_bank)->first();
        $bank = $row_bank->bank.', No Rekening : '.$row_bank->norek.', An : '.$row_bank->an.', Cabang : '.$row_bank->cabang;

        $no_donasi       = no_donasi();  
        $p['no_donasi']  = $no_donasi;  
        $p['status']     = 'Donasi Baru';       
        $p['id_donatur'] = $id_donatur;     
        $p['nama']       = $nama;     
        $p['tlpn']       = $tlpn;     
        $p['email']       = $email;     
        $p['bank']       = $bank;       
        $p['tgl_donasi'] = date('Y-m-d H:i:s');
        DB::table('donasi')->insert($p);
        $lastInsertId    = DB::getPdo()->lastInsertId();

        if ($donasi_item) {
            $donasi_item = $donasi_item;
            $donasi_item = json_decode($donasi_item,true);
            foreach ($donasi_item as $item) {
                $id_req_buku = $item['id_req_buku'];
                $req_buku    = DB::table('req_buku')->where('id',$id_req_buku)->first(); 
                $kategori    = show_value($req_buku->id_kategori_buku,'kategori_buku','nama');               
                
                $q['id_donasi']   = $lastInsertId;
                $q['id_req_buku'] = $item['id_req_buku'];
                $q['qty']         = $item['qty'];
                $q['id_tbm']      = $req_buku->id_tbm;
                $q['judul']       = $req_buku->judul;
                $q['kategori']    = $kategori;
                $q['penerbit']    = $req_buku->penerbit;
                $q['toko_buku']   = $req_buku->toko_buku;
                $q['pengarang']   = $req_buku->pengarang;
                $q['harga']       = $req_buku->harga;
                DB::table('donasi_item')->insert($q);
            }
        }


        // result
        $donasi            = DB::table('donasi')->where('id',$lastInsertId)->first();
        $data['id']        = $donasi->id;
        $data['total']     = total($donasi->id);
        $data['no_donasi'] = $donasi->no_donasi;
        $data['tgl_donasi'] = $donasi->tgl_donasi;



        // send email
        $donasi      = DB::table('donasi')->where('id',$lastInsertId)->first();
        $donasi_item = DB::table('donasi_item')->where('id_donasi',$lastInsertId)->get();

        $donasi_item_html ='';
        foreach ($donasi_item as $item) {
            $donasi_item_html .= '
                            <tr>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.show_value($item->id_tbm,'tbm','nama').'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.$item->judul.'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->qty).'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->harga).'</td>
                            <td style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px;font-weight:bold;">'.number_format($item->qty*$item->harga).'</td>
                            </tr>
                            ';
        }

        // email ke forum
        $html  = '<h2>Kemendikbud - TBM, Donasi Baru '.$donasi->no_donasi.'</h2>
                <h4>Ada Donasi baru, Detail donasi sebagai berikut :</h4>
                <p>No Donasi : '.$donasi->no_donasi.'</p>
                <p>Total Donasi : '.number_format(total($donasi->id)).'</p>
                <p>Nama : '.$donasi->nama.'</p>
                <p>Telepon : '.$donasi->tlpn.'</p>
                <p>Email : '.$donasi->email.'</p>
                <p>Bank yang Dituju : '.$donasi->bank.'</p>
                <p>Tanggal : '.$donasi->tgl_donasi.'</p>
                <h4>Donasi Item</h4>
                <table cellspacing="0" cellpadding="6" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4" border="1">
                    <thead>
                    <tr>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">TBM</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Buku</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">QTY</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Harga</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    '.$donasi_item_html.'
                    </tbody>
                </table>
                <p>Untuk lebih lengkapnya dapat di lihat pada <a href="'.url('/admin/donasi/sub-module/'.$donasi->id.'/donasi_item').'">Panel Admin</a></p>';
        send_email(get_setting('email_forum'),'Kemendikbud - TBM, Donasi Baru'.$donasi->no_donasi,$html);

        // email ke donatur
        $html  = '<h2>Kemendikbud - TBM, Donasi '.$donasi->no_donasi.'</h2>
                <h4>Terimakasih telah melakukan donasi, Detail donasi sebagai berikut :</h4>
                <p>No Donasi : '.$donasi->no_donasi.'</p>
                <p>Total Donasi : '.number_format(total($donasi->id)).'</p>
                <p>Nama : '.$donasi->nama.'</p>
                <p>Telepon : '.$donasi->tlpn.'</p>
                <p>Email : '.$donasi->email.'</p>
                <p>Tanggal : '.$donasi->tgl_donasi.'</p>
                <h4>Donasi Item</h4>
                <table cellspacing="0" cellpadding="6" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4" border="1">
                    <thead>
                    <tr>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">TBM</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Buku</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">QTY</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Harga</th>
                        <th scope="col" style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    '.$donasi_item_html.'
                    </tbody>
                </table>

                <h4>Segera lakukan transfer pada bank yang dituju</h4>
                <p>'.$donasi->bank.'</p>
                <p>Bila Sudah Transfer silahkan untuk melakukan konfirmasi pembayaran, untuk konfirmasi pembayaran silahkan <a href="'.url('/profile/konfirmasi-pembayaran/'.$donasi->id).'">klik disni</a></p>';            
        send_email($donasi->email,'Kemendikbud - TBM, Donasi '.$donasi->no_donasi,$html);
        // /send email

        $result['api_status']  = 1;
        $result['api_message'] = 'success';
        $result['data']        = $data;
        $res = response()->json($result);
        $res->send();
        exit;

    }

    public function hook_query(&$query) {
        //You can custom the api query 

    }

    public function hook_after($postdata,&$result) {
        //Code here if you want execute some action after API Query Called

    }

}