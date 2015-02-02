import java.awt.Color;
import java.awt.Graphics;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.util.Random;

import javax.swing.JApplet;
import javax.swing.JButton;
import javax.swing.JPanel;


public class PingPongApplet extends JApplet implements Runnable {
	private static final int BOARD_HEIGHT = 75, BALL_BASE_SPEED = 5, BOARD_PADDING = 20, BALL_RADIUS = 5;
	private int width, height, lBoardY, rBoardY, lBoardDelta,
		lScore, rScore, state = 0, mouseY;
	private double ballX, ballY, ballXDelta, ballYDelta;
	private boolean mouseIn = false, mouseDown = false;
	
	public int getLScore() {
		return lScore;
	}
	public double getScoreEncrypted() {
		return new Random(lScore).nextDouble();
	}
	
	public void run() {
		try {
		btnStart.setText("3");
		Thread.sleep(1000);
		btnStart.setText("2");
		Thread.sleep(1000);
		btnStart.setText("1");
		Thread.sleep(1000);
		btnStart.setVisible(false);
		} catch (InterruptedException ex) { }
		RoundLoop: while (true) {
			try {
				Thread.sleep(10);
				
				// Begin calculating position of ball and boards at next tick
				if (ballX < BOARD_PADDING) {
					if (ballY < lBoardY || ballY > lBoardY + BOARD_HEIGHT) {
						rScore++;
						break RoundLoop;
					} else {
						double outerPart, innerPart;
						if ((ballY - lBoardY) < BOARD_HEIGHT / 2) {
							outerPart = ballY - lBoardY;
							innerPart = BOARD_HEIGHT / 2 - outerPart;
							ballYDelta = -(BALL_BASE_SPEED / Math.sqrt(1 + outerPart * outerPart / (innerPart * innerPart)));
							ballXDelta = (BALL_BASE_SPEED / Math.sqrt(1 + innerPart * innerPart / (outerPart * outerPart)));
						} else if ((ballY - lBoardY) > BOARD_HEIGHT / 2) {
							innerPart = ballY - lBoardY - BOARD_HEIGHT / 2;
							outerPart = BOARD_HEIGHT / 2 - innerPart;
							ballYDelta = (BALL_BASE_SPEED / Math.sqrt(1 + outerPart * outerPart / (innerPart * innerPart)));
							ballXDelta = (BALL_BASE_SPEED / Math.sqrt(1 + innerPart * innerPart / (outerPart * outerPart)));
						} else {
							ballYDelta = 0;
							ballXDelta = BALL_BASE_SPEED;
						}
					}
				}
				if (ballX > width - BOARD_PADDING) {
					if (ballY < rBoardY || ballY > rBoardY + BOARD_HEIGHT) {
						lScore++;
						break RoundLoop;
					} else {
						double outerPart, innerPart;
						if ((ballY - rBoardY) < BOARD_HEIGHT / 2) {
							outerPart = ballY - rBoardY;
							innerPart = BOARD_HEIGHT / 2 - outerPart;
							ballYDelta = -(BALL_BASE_SPEED / Math.sqrt(1 + outerPart * outerPart / (innerPart * innerPart)));
							ballXDelta = -(BALL_BASE_SPEED / Math.sqrt(1 + innerPart * innerPart / (outerPart * outerPart)));
						} else if ((ballY - rBoardY) > BOARD_HEIGHT / 2) {
							innerPart = ballY - rBoardY - BOARD_HEIGHT / 2;
							outerPart = BOARD_HEIGHT / 2 - innerPart;
							ballYDelta = (BALL_BASE_SPEED / Math.sqrt(1 + outerPart * outerPart / (innerPart * innerPart)));
							ballXDelta = -(BALL_BASE_SPEED / Math.sqrt(1 + innerPart * innerPart / (outerPart * outerPart)));
						} else {
							ballYDelta = 0;
							ballXDelta = -BALL_BASE_SPEED;
						}
					}
				}
				if (ballY < BALL_RADIUS || ballY > height - BALL_RADIUS)
					ballYDelta *= -1;
				
				ballX += ballXDelta;
				ballY += ballYDelta;
				if (mouseIn) {
					if (mouseY > lBoardY + BOARD_HEIGHT / 2 + 5)
						lBoardDelta = 2;
					else if (mouseY < lBoardY + BOARD_HEIGHT / 2 - 5)
						lBoardDelta = -2;
					else
						lBoardDelta = 0;
					lBoardY += lBoardDelta;
				}
				if (ballY < rBoardY + BOARD_HEIGHT / 2 - 5)
					rBoardY -= 2;
				else if (ballY > rBoardY + BOARD_HEIGHT / 2 + 5)
					rBoardY += 2;
				
				PingPongApplet.this.repaint();
			} catch (InterruptedException e) { }
		}
		btnStart.setVisible(true);
		if (lScore - rScore >= 3 || rScore - lScore >= 3) {
			state = 0;
			btnStart.setText("Game over, winner is " + (lScore > rScore ? "Human" : "AI"));
		} else {
			state = 2;
			btnStart.setText("Round end, click here to continue");
		}
		PingPongApplet.this.repaint();
	}
	
	private JPanel panMain;
	private JButton btnStart;
	
	@SuppressWarnings("serial")
	@Override
	public void init() {
		btnStart = new JButton("Go");
		btnStart.addActionListener(new ActionListener() {
			
			@Override
			public void actionPerformed(ActionEvent arg0) {
				if (state == 0) { // Start a new game
					lScore = 0;
					rScore = 0;
					lBoardY = (height - BOARD_HEIGHT) / 2;
					rBoardY = (height - BOARD_HEIGHT) / 2;
					ballX = width / 2;
					ballY = height / 2;
					ballXDelta = -BALL_BASE_SPEED + (new Random().nextInt() % 2) * BALL_BASE_SPEED * 2;
					ballYDelta = 0;
					mouseY = height / 2;
					state = 1;
					new Thread(PingPongApplet.this).start();
				} else if (state == 1) { // In game: ignore this
					
				} else if (state == 2) { // Round finished
					ballX = width / 2;
					ballY = height / 2;
					ballXDelta = -BALL_BASE_SPEED + (new Random().nextInt() % 2) * BALL_BASE_SPEED * 2;
					ballYDelta = 0;
					lBoardY = (height - BOARD_HEIGHT) / 2;
					rBoardY = (height - BOARD_HEIGHT) / 2;
					mouseY = height / 2;
					state = 1;
					new Thread(PingPongApplet.this).start();
				}
			}
		});
		width = this.getWidth();
		height = this.getHeight();
		this.getContentPane().add(panMain = new JPanel() {
			@Override
			public void paint(Graphics g) {
				super.paint(g);
				g.setColor(Color.BLACK);
				g.drawRect(BOARD_PADDING - BALL_RADIUS, lBoardY, 2, BOARD_HEIGHT);
				g.drawRect(width - BOARD_PADDING + BALL_RADIUS, rBoardY, 2, BOARD_HEIGHT);
				g.setColor(Color.DARK_GRAY);
				g.fillOval((int) ballX - BALL_RADIUS, (int) ballY - BALL_RADIUS, BALL_RADIUS * 2, BALL_RADIUS * 2);
				g.setColor(Color.RED);
				g.drawString("Left score: " + lScore, 20, height - 20);
				g.drawString("Right score: " + rScore, width / 2, height - 20);
			}
		});
		panMain.addMouseListener(new MouseListener() {
			
			@Override
			public void mouseReleased(MouseEvent arg0) {
				mouseDown = false;
			}
			
			@Override
			public void mousePressed(MouseEvent arg0) {
				mouseDown = true;
			}
			
			@Override
			public void mouseExited(MouseEvent arg0) {
				mouseIn = false;
			}
			
			@Override
			public void mouseEntered(MouseEvent arg0) {
				mouseIn = true;
			}
			
			@Override
			public void mouseClicked(MouseEvent arg0) {
				// Do nothing
				
			}
		});
		panMain.addMouseMotionListener(new MouseMotionListener() {
			
			@Override
			public void mouseMoved(MouseEvent arg0) {
				mouseY = arg0.getY();
			}
			
			@Override
			public void mouseDragged(MouseEvent arg0) {
				// Do nothing
			}
		});
		panMain.add(btnStart);
	}
}
