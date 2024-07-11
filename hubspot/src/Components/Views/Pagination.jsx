import React, { useEffect } from "react";
import ReactPaginate from 'react-paginate';

export default function Pagination({currentPage, totalPages, setCurrentPage, changePage, param})
{
    const onPageChange = (page) => {
        let next = page.selected + 1;
        setCurrentPage(next);
        param.pageNumber = next;
        changePage(param);
    }

    return (
        <ReactPaginate className="w-full flex justify-center align-center relative"
            breakLabel="..."
            previousLabel={
                <span className="bg-white px-4 py-1.5 border-2 border-gray-200 absolute left-0">
                    <i className="fa-solid fa-arrow-left mr-2"></i>
                    Previous
                </span>
            }
            onPageChange={onPageChange}
            pageRangeDisplayed={5}
            pageCount={totalPages}
            containerClassName="block w-full bg-blue-500 list-none "
            pageClassName="px-4 py-1 flex justify-center align-center text-gray-500"
            nextLabel={
                <span className="bg-white px-4 py-1.5 border-2 border-gray-200 absolute right-0">
                     Next
                    <i className="fa-solid fa-arrow-right ml-2"></i>
                </span>
            }
            forcePage={param.pageNumber -1}
            activeClassName="bg-gray-100 text-gray-700 rounded-md"
            renderOnZeroPageCount={null}
        />
    )
}