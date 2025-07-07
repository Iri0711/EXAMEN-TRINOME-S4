 Chart.register({
        id: 'totalCenterText',
        beforeDraw(chart) {
            const { width } = chart;
            const { height } = chart;
            const ctx = chart.ctx;
            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

            ctx.save();
            ctx.font = 'bold 18px Open';
            ctx.fillStyle = '#1F4E5F';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(total.toString(), width-50,15);
            ctx.restore();
        }
    });


function createCourbe(id,titre,max,data,labels){
    const ctx = document.getElementById(id).getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels:labels, 
            datasets: [{
                label: titre,
                data: data,
                fill: true,
                borderColor: '#3AB7D9',
                tension: 0.4
            }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: max
                    }
                },
                responsive:true,
                maintainAspectRatio:false
            }
        });
};
function createPolar(id,titre,data,labels){
    const ctx = document.getElementById(id).getContext('2d');
    const gradient = ctx.createLinearGradient(0, 300, 100, 0); // haut → bas
    gradient.addColorStop(0, '#F5F5F5');
    gradient.addColorStop(1, '#3399FF');

        const myChart = new Chart(ctx, {
            type: 'polarArea',
            data: {
            labels:labels, 
            datasets: [{
                label: titre,
                data: data,
                fill: true,
                borderColor: '#3AB7D9',
                backgroundColor:gradient,
                tension: 0.2,
                borderWidth:1
            }]
            },
            options: {
                plugins:{
                    legend:{
                        position:"bottom"
                    }
                },
                responsive:true,
                maintainAspectRatio:false,
                scales: {
                r: {
                ticks: {
                    display: false 
                },
                grid: {
                    display: false 
                },
                angleLines: {
                    display: true 
                },
                pointLabels: {
                    display: true 
                }
                }
            }
            }
        });
};

function createBar(id,titre,max,data,labels){
    const ctx = document.getElementById(id).getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
            labels:labels, 
            datasets: [{
                label: titre,
                data: data,
                fill: true,
                borderColor: '#3AB7D9',
                backgroundColor:'#F77F00',
                tension: 0.4,
                
            }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: max
                    }
                },
                responsive:true,
                maintainAspectRatio:false
            }
        });
};

function createPie(id,titre,data,labels,baseColors){
    const ctx = document.getElementById(id).getContext('2d');
    const colors = generateColors(data.length, baseColors);

        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
            labels:labels, 
            datasets: [{
                label: titre,
                data: data,
                backgroundColor:colors,
                borderColor: '#ffffff',
                borderWidth:2
            }]
            },
            options: {
                
                responsive:true,
                maintainAspectRatio:false,
                plugins:{
                    legend:{
                        position:"bottom",
                    }  
                },
            }
        });
};
function createDonut(id,titre,data,labels,baseColors){
    const ctx = document.getElementById(id).getContext('2d');
    const colors = generateColors(data.length, baseColors);

        const myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
            labels:labels, 
            datasets: [{
                label: titre,
                data: data,
                backgroundColor:colors,
                borderColor: '#ffffff',
                borderWidth:2
            }]
            },
            options: {
                cutout:'70',
                responsive:true,
                maintainAspectRatio:false,
                plugins:{
                    legend:{
                        position:"bottom",
                    }  
                },
            }
        });
};

function generateColors(n, baseColors) {
  const palette = [
    '#A8D5BA', '#F5F5F5', '#E07A5F', '#81B29A',
    '#3D405B', '#F2CC8F', '#6D597A', '#FFB703', '#023047'
  ];
  const colors = [...baseColors];
  let i = 0;
  while (colors.length < n) {
    colors.push(palette[i % palette.length]);
    i++;
  }
  return colors;
}

