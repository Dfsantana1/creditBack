<?php

namespace App\Services\Pdf;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;

/**
 * Class DomPdfWrapperService
 *
 * @category Service
 * @package  App\Services\Pdf
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class DomPdfWrapperService
{

    /**
     * @var PDF
     */
    public PDF $pdf;


    /**
     * @param PDF $pdf
     */
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;

    }//end __construct()


    /**
     * @return $this
     */
    public function initialise(): self
    {
        $this->pdf->setOption('isRemoteEnabled', true);
        $this->pdf->setOption('isHtml5ParserEnabled', true);
        $this->pdf->setOption(
            'httpContext',
            stream_context_create(
                [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true,
                    ],
                ]
            )
        );

        return $this;

    }//end initialise()


    /**
     * @param  string $viewPath
     * @param  array  $data
     * @return $this
     */
    public function setViewAndData(string $viewPath, array $data): self
    {
        $this->pdf->loadView($viewPath, $data);

        return $this;

    }//end setViewAndData()


    /**
     * @param  $fileName
     * @return Response
     */
    public function download($fileName): Response
    {
        return $this->pdf->download($fileName);

    }//end download()


}//end class
