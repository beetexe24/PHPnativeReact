import React from "react";


export default function Skeleton({displaySkeleton})
{
    const data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    return (
        <tbody style={{ display: displaySkeleton }}>
            {
                data.map((row, index) => (
                <tr key={index}>
                    <td scope="row" className="animate-pulse px-6 py-4 font-medium text-gray-400 whitespace-nowrap dark:text-white">
                        <div className="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                    </td>
                    <td scope="row" className="animate-pulse px-6 py-4 font-medium text-gray-400 whitespace-nowrap dark:text-white">
                        <div className="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                    </td>
                    <td scope="row" className="animate-pulse px-6 py-4 font-medium text-gray-400 whitespace-nowrap dark:text-white">
                        <div className="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                    </td>
                    <td scope="row" className="animate-pulse px-6 py-4 font-medium text-gray-400 whitespace-nowrap dark:text-white">
                        <div className="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                    </td>
                    <td scope="row" className="animate-pulse px-6 py-4 font-medium text-gray-400 whitespace-nowrap dark:text-white">
                        <div className="h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                    </td>
                </tr>
                ))
            }
            
        </tbody>
    )
}