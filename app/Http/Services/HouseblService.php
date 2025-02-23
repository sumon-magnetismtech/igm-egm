<?php

namespace App\Http\Services;

use App\Http\Requests\EgmHouseBlRequest;
use App\Http\Requests\HouseblRequest;
use App\Imports\ContainerDetailsImport;
use App\Vatreg;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class HouseblService
{
    /**
     * @param \App\Http\Requests\HouseblRequest $request
     * @return array
     */
    public function handleHousebl(HouseblRequest $request): array
    {
        if ($request->consignee_status == 1 || $request->notify_status == 1)
        {
            if ($request->consigneebin == $request->notifybin)
            {
                Vatreg::create(['BIN' => $request->consigneebin, 'NAME' => $request->consigneename, 'ADD1' => $request->consigneeaddress]);
                echo 'Notify consignee same';
            }
            else
            {
                if ($request->consignee_status == 1)
                {
                    Vatreg::create(['BIN' => $request->consigneebin, 'NAME' => $request->consigneename, 'ADD1' => $request->consigneeaddress]);
                    echo 'consignee Bin';
                }
                if ($request->notify_status == 1)
                {
                    Vatreg::create(['BIN' => $request->notifybin, 'NAME' => $request->notifyname, 'ADD1' => $request->notifyaddress]);
                    echo 'Notify Bin';
                }
            }
        }

        $blInformationData                    = $request->only('qccontainer', 'igm', 'blNote', 'line', 'consigneebin', 'consigneebin', 'consigneename', 'consigneeaddress', 'notifybin', 'notifyname', 'notifyaddress', 'packageno', 'packagecode', 'packagetype', 'grosswt', 'measurement', 'containernumber', 'remarks', 'freightstatus', 'freightvalue', 'coloader', 'note');
        $blInformationData['bolreference']    = strtoupper($request->bolreference);
        $blInformationData['exportername']    = strtoupper($request->exportername);
        $blInformationData['exporteraddress'] = strtoupper($request->exporteraddress);
        $blInformationData['shippingmark']    = strtoupper($request->shippingmark);
        $blInformationData['description']     = strtoupper($request->description);
        $blInformationData['qccontainer']     = $request->qccontainer ? true : false;

        if (empty($request->hasFile('file')))
        {
            $containersData = $request->addmore;
        }
        else
        {
            $container      = Excel::toCollection(new ContainerDetailsImport(), request()->file('file'));
            $containersData = $container->collapse()->toArray();
        }
        if (empty($containersData))
        {
            throw new \Exception('Please Upload Container via given Excel format or add Manually.');
        }

        //validate container data
        $this->validateContainerInformation($containersData);

        $containersPkgno   = 0;
        $containersGrossWt = 0;

        foreach ($containersData as $containers)
        {
            $containersPkgno += $containers['pkgno'];
            $containersGrossWt += $containers['grosswt'];
        }

        $grosswtInFloat           = number_format($request->grosswt, 2, '.', '');
        $containersGrossWtInFloat = number_format($containersGrossWt, 2, '.', '');

        $containersStatus = Arr::pluck($containersData, 'status');
        $containersImco   = Arr::pluck($containersData, 'imco');

        $blInformationData['consolidated'] = in_array('prt', array_map('strtolower', $containersStatus)) || in_array('lcl', array_map('strtolower', $containersStatus)) ? true : false;
        $blInformationData['dg']           = array_filter($containersImco) ? true : false;

        $hbl_addmores = $this->prepareContainerDataToStore($containersData);

        if ($request->containernumber != count($containersData))
        {
            throw new \Exception("Number of Containers didn't Match.");
        }
        if ($request->packageno != $containersPkgno)
        {
            throw new \Exception("Number of Package didn't Match.");
        }
        if ($grosswtInFloat != $containersGrossWtInFloat)
        {
            throw new \Exception("Total Gross Weight Mismatch.
            Gross Weight : $grosswtInFloat, Container Gross Weight : $containersGrossWtInFloat. Difference : " .
                ($grosswtInFloat != $containersGrossWtInFloat));
        }

        return [
            'blInformationData' => $blInformationData,
            'hbl_addmores'      => $hbl_addmores,
            'request'           => $request,
        ];
    }
    public function handleEgmHousebl(EgmHouseBlRequest $request): array
    {
        if ($request->consignee_status == 1 || $request->notify_status == 1)
        {
            if ($request->consigneebin == $request->notifybin)
            {
                Vatreg::create(['BIN' => $request->consigneebin, 'NAME' => $request->consigneename, 'ADD1' => $request->consigneeaddress]);
                echo 'Notify consignee same';
            }
            else
            {
                if ($request->consignee_status == 1)
                {
                    Vatreg::create(['BIN' => $request->consigneebin, 'NAME' => $request->consigneename, 'ADD1' => $request->consigneeaddress]);
                    echo 'consignee Bin';
                }
                if ($request->notify_status == 1)
                {
                    Vatreg::create(['BIN' => $request->notifybin, 'NAME' => $request->notifyname, 'ADD1' => $request->notifyaddress]);
                    echo 'Notify Bin';
                }
            }
        }

        $blInformationData                    = $request->only('qccontainer', 'igm', 'blNote', 'line', 'consigneebin', 'consigneebin', 'consigneename', 'consigneeaddress', 'notifybin', 'notifyname', 'notifyaddress', 'packageno', 'packagecode', 'packagetype', 'grosswt', 'measurement', 'containernumber', 'remarks', 'freightstatus', 'freightvalue', 'coloader', 'note');
        $blInformationData['bolreference']    = strtoupper($request->bolreference);
        $blInformationData['exportername']    = strtoupper($request->exportername);
        $blInformationData['exporteraddress'] = strtoupper($request->exporteraddress);
        $blInformationData['shippingmark']    = strtoupper($request->shippingmark);
        $blInformationData['description']     = strtoupper($request->description);
        $blInformationData['qccontainer']     = $request->qccontainer ? true : false;

        if (empty($request->hasFile('file')))
        {
            $containersData = $request->addmore;
        }
        else
        {
            $container      = Excel::toCollection(new ContainerDetailsImport(), request()->file('file'));
            $containersData = $container->collapse()->toArray();
        }
        if (empty($containersData))
        {
            throw new \Exception('Please Upload Container via given Excel format or add Manually.');
        }

        //validate container data
        $this->validateContainerInformation($containersData);

        $containersPkgno   = 0;
        $containersGrossWt = 0;

        foreach ($containersData as $containers)
        {
            $containersPkgno += $containers['pkgno'];
            $containersGrossWt += $containers['grosswt'];
        }

        $grosswtInFloat           = number_format($request->grosswt, 2, '.', '');
        $containersGrossWtInFloat = number_format($containersGrossWt, 2, '.', '');

        $containersStatus = Arr::pluck($containersData, 'status');
        $containersImco   = Arr::pluck($containersData, 'imco');

        $blInformationData['consolidated'] = in_array('prt', array_map('strtolower', $containersStatus)) || in_array('lcl', array_map('strtolower', $containersStatus)) ? true : false;
        $blInformationData['dg']           = array_filter($containersImco) ? true : false;

        $hbl_addmores = $this->prepareContainerDataToStore($containersData);

        if ($request->containernumber != count($containersData))
        {
            throw new \Exception("Number of Containers didn't Match.");
        }
        if ($request->packageno != $containersPkgno)
        {
            throw new \Exception("Number of Package didn't Match.");
        }
        if ($grosswtInFloat != $containersGrossWtInFloat)
        {
            throw new \Exception("Total Gross Weight Mismatch.
            Gross Weight : $grosswtInFloat, Container Gross Weight : $containersGrossWtInFloat. Difference : " .
                ($grosswtInFloat != $containersGrossWtInFloat));
        }

        return [
            'blInformationData' => $blInformationData,
            'hbl_addmores'      => $hbl_addmores,
            'request'           => $request,
        ];
    }

    /**
     * @param $containers
     */
    private function validateContainerInformation($containers)
    {
        return Validator::make($containers, [
            '*.contref' => 'bail|required|alpha_num|size:11|distinct',
            '*.pkgno'   => ['required', 'numeric'],
            '*.grosswt' => 'required|numeric|',
            '*.status'  => 'required|size:3',
        ])->validate();
    }

    /**
     * @param $containers
     * @return mixed
     */
    private function prepareContainerDataToStore($containers)
    {
        $hbl_addmores = [];
        foreach ($containers as $addmore)
        {
            $hbl_addmores[] = [
                'contref'   => strtoupper($addmore['contref']),
                'type'      => strtoupper($addmore['type']),
                'status'    => $addmore['status'],
                'sealno'    => strtoupper($addmore['sealno']),
                'pkgno'     => $addmore['pkgno'],
                'grosswt'   => $addmore['grosswt'],
                'imco'      => $addmore['imco'],
                'un'        => $addmore['un'],
                'location'  => $addmore['location'],
                'commodity' => $addmore['commodity'],
            ];
        }

        return $hbl_addmores;
    }
}
