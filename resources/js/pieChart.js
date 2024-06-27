import React from "react";
import { Pie } from "react-chartjs-2";
import { Card } from "antd";

const PieChartComponent = ({ tagihanSudahDibayar, tagihanBelumDibayar }) => {
    const data = {
        labels: ["Tagihan Sudah Dibayar", "Tagihan Belum Dibayar"],
        datasets: [
            {
                label: "Status Tagihan",
                data: [tagihanSudahDibayar, tagihanBelumDibayar],
                backgroundColor: [
                    "rgba(54, 162, 235, 0.6)", // Warna untuk tagihan sudah dibayar
                    "rgba(255, 99, 132, 0.6)", // Warna untuk tagihan belum dibayar
                ],
                borderColor: ["rgba(54, 162, 235, 1)", "rgba(255, 99, 132, 1)"],
                borderWidth: 1,
            },
        ],
    };

    const options = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: "top",
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function (
                        previousValue,
                        currentValue,
                        currentIndex,
                        array
                    ) {
                        return previousValue + currentValue;
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    var percentage = Math.floor(
                        (currentValue / total) * 100 + 0.5
                    );
                    return percentage + "%";
                },
            },
        },
    };

    return (
        <Card title="Status Tagihan">
            <Pie data={data} options={options} />
        </Card>
    );
};

export default PieChartComponent;
