import { initFlowbite } from "flowbite";
import { useEffect, useState } from "react";
import Datepicker from "react-tailwindcss-datepicker"; 
import '@fortawesome/fontawesome-free/css/all.min.css';
import axios from 'axios';
import Pagination from "./Pagination";
import Content from "./Content";
import Skeleton from "./Skeleton";


export default function Index(){
    const [data, setData] = useState([]);
    const [displaySkeleton, setDisplaySkeleton] = useState('relative');
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(0);
    const [value, setValue] = useState({
        startDate: "2024-07-01",
        endDate: "2024-07-31"
    });
    const [filter, setFilter] = useState('Customer date');
    
    const [params, setParams] = useState({
        "pageNumber": currentPage,
        "startDate": '2024-07-01',
        "endDate": '2024-07-31',
        "filterBy": filter
    });

    useEffect(() => {
        initFlowbite();
        

        fetch(params);
        justpost();

    }, [])

    
    

    const handleValueChange = (newValue) => {
        const param = {
            "pageNumber": currentPage,
            "startDate": newValue.startDate,
            "endDate": newValue.endDate,
            "filterBy": filter
        }
        setValue(newValue);
        setParams(param);
    }

    const dropdownHandleChange = (e) => {
        params.filterBy = e.target.value;
        //params.pageNumber = 1;
        setFilter(e.target.value);
        //setCurrentPage(1);
    }

    const connectHandleClick = (e) => {
        params.pageNumber = 1;
        setCurrentPage(1);
        fetch(params);
    }

    const fetch = (param) => {
        setDisplaySkeleton('relative');
        axios.get('http://localhost:8000/api/fetch', {params: param})
            .then(response => {
            if(response.data.success)
            {
                setData(response.data.data.results);
                setTotalPages(response.data.total_pages);
            }

            setTimeout(() => {
                setDisplaySkeleton('none');
            }, 500);
        })
        .catch((error) => {
            console.log(error);
            setTimeout(() => {
                setDisplaySkeleton('none');
            }, 500);
        });
    }

    const justpost = () => {
        axios.post('http://localhost:8000/api/justpost', {data: "newdata"}, {headers: {
            'Content-Type': 'application/json',
        }})
            .then(response => {
            if(response.data.success)
            {
                console.log("Success");
            }
        })
        .catch((error) => {
            console.log(error);
        });
    }

    return(
        <div className="w-full lg:w-5/6 flex flex-col-reverse lg:flex-row flex-nowrap justify-between mx-auto px-4 mb-4">
            <div className="w-full lg:w-3/4 h-auto mt-8 sm:rounded-lg bg-white">
                <div className="w-full relative sm:rounded-lg p-5 h-screen border-solid border-2 border-gray-200">
                    <div className="w-full h-[calc(100%-3.5rem)] overflow-auto">
                        <div className="flex flex-row">
                            <div className="w-2/4">
                                <span className="font-bold">Data</span>
                            </div>
                            
                            <div className="w-2/4 p-1">
                                <div className="flex float-right">
                                    <select name="filterBy" onChange={dropdownHandleChange} id="filterBy" className="w-48 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="Customer date">Customer date</option>
                                        <option value="Lead date">Lead date</option>
                                    </select>
                                    <button type="submit" onClick={connectHandleClick} className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1 text-center ml-2">Connect</button>
                                </div>
                            </div>
                        </div>
                        
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500 p-5 mt-5">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3">
                                        Email
                                    </th>
                                    <th className="px-6 py-3">
                                        First Name
                                    </th>
                                    <th className="px-6 py-3">
                                        Last Name
                                    </th>
                                    <th className="px-6 py-3">
                                        Customer Date
                                    </th>
                                    <th className="px-6 py-3">
                                        Lead Date
                                    </th>
                                </tr>
                            </thead>
                            
                            {
                                (displaySkeleton == 'relative') ?
                                <Skeleton displaySkeleton={displaySkeleton}/>
                                :
                                <Content data={data}/>

                            }
                                
                        </table>
                    </div>
                    

                    <div className="mt-5 h-8">
                        <Pagination 
                            currentPage={currentPage}
                            totalPages={totalPages}
                            setCurrentPage={setCurrentPage}
                            changePage={fetch}
                            param={params}
                        />
                    </div>
                </div>
            </div>


            <div className="w-full h-full lg:w-1/4 mt-8 sm:rounded-lg bg-red-500">
                <Datepicker value={value} showShortcuts={true} showFooter={true} onChange={handleValueChange} />
            </div>
        
        </div>
    )
}